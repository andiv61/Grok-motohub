const express = require('express');
const multer = require('multer');
const xlsx = require('xlsx');
const fs = require('fs').promises;
const path = require('path');
const nodeSchedule = require('node-schedule');
const app = express();
const upload = multer({ dest: 'uploads/' });

async function ensureDirs() {
  for (const dir of ['uploads', 'data']) {
    try { await fs.mkdir(dir, { recursive: true }); } catch {}
  }
}
ensureDirs();

app.use(express.json());
app.use(express.static('public'));

// --- Импорт каталога ---
app.post('/api/import/catalog', upload.single('file'), async (req, res) => {
  try {
    const filePath = req.file.path;
    const workbook = xlsx.readFile(filePath);
    const sheetName = workbook.SheetNames[0];
    const data = xlsx.utils.sheet_to_json(workbook.Sheets[sheetName]);
    const catalog = { catalog: { scooters_up_to_50cc: data } };
    await fs.writeFile('data/catalog.json', JSON.stringify(catalog, null, 2), 'utf8');
    await fs.unlink(filePath);
    res.json({ message: 'Каталог успешно загружен' });
  } catch (error) {
    res.status(500).json({ message: 'Ошибка: ' + error.message });
  }
});

// --- Экспорт каталога ---
app.get('/api/export/catalog', async (req, res) => {
  try {
    const catalog = JSON.parse(await fs.readFile('data/catalog.json', 'utf8'));
    const data = catalog.catalog.scooters_up_to_50cc;
    const ws = xlsx.utils.json_to_sheet(data);
    const wb = xlsx.utils.book_new();
    xlsx.utils.book_append_sheet(wb, ws, 'Catalog');
    const buffer = xlsx.write(wb, { type: 'buffer', bookType: 'xlsx' });
    res.setHeader('Content-Disposition', 'attachment; filename="catalog.xlsx"');
    res.send(buffer);
  } catch (error) {
    res.status(500).json({ message: 'Ошибка: ' + error.message });
  }
});

// --- Импорт прайс-листа ---
app.post('/api/import/pricelist', upload.single('file'), async (req, res) => {
  try {
    const filePath = req.file.path;
    const workbook = xlsx.readFile(filePath);
    const sheetName = workbook.SheetNames[0];
    const data = xlsx.utils.sheet_to_json(workbook.Sheets[sheetName]);
    await fs.writeFile('data/pricelist.json', JSON.stringify(data, null, 2), 'utf8');
    await fs.unlink(filePath);
    res.json({ message: 'Прайс-лист успешно импортирован' });
  } catch (error) {
    res.status(500).json({ message: 'Ошибка: ' + error.message });
  }
});

// --- Экспорт прайс-листа ---
app.get('/api/export/pricelist', async (req, res) => {
  try {
    const data = JSON.parse(await fs.readFile('data/pricelist.json', 'utf8'));
    const ws = xlsx.utils.json_to_sheet(data);
    const wb = xlsx.utils.book_new();
    xlsx.utils.book_append_sheet(wb, ws, 'PriceList');
    const buffer = xlsx.write(wb, { type: 'buffer', bookType: 'xlsx' });
    res.setHeader('Content-Disposition', 'attachment; filename="pricelist.xlsx"');
    res.send(buffer);
  } catch (error) {
    res.status(500).json({ message: 'Ошибка: ' + error.message });
  }
});

// --- Автоматическая загрузка каталога по расписанию (2:00) ---
nodeSchedule.scheduleJob('0 2 * * *', async () => {
  try {
    const filePath = path.join(__dirname, 'uploads', 'catalog.xlsx');
    if (await fs.stat(filePath).catch(() => false)) {
      const workbook = xlsx.readFile(filePath);
      const sheetName = workbook.SheetNames[0];
      const data = xlsx.utils.sheet_to_json(workbook.Sheets[sheetName]);
      const catalog = { catalog: { scooters_up_to_50cc: data } };
      await fs.writeFile('data/catalog.json', JSON.stringify(catalog, null, 2), 'utf8');
      await fs.unlink(filePath);
      console.log('Авто-обновление каталога выполнено');
    }
  } catch (error) {
    console.error('Ошибка авто-обновления каталога:', error.message);
  }
});

app.listen(3000, () => console.log('Сервер запущен на 3000'));