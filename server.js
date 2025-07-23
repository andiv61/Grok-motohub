const express = require('express');
const multer = require('multer');
const xlsx = require('xlsx');
const fs = require('fs').promises;
const nodeSchedule = require('node-schedule');
const app = express();
const upload = multer({ dest: 'uploads/' });

app.use(express.json());
app.use(express.static('public'));

app.post('/api/import/catalog', upload.single('file'), async (req, res) => {
  try {
    const filePath = req.file.path;
    const workbook = xlsx.readFile(filePath);
    const sheetName = workbook.SheetNames[0];
    const data = xlsx.utils.sheet_to_json(workbook.Sheets[sheetName]);
    const catalog = { catalog: { scooters_up_to_50cc: data } };
    await fs.writeFile('data/catalog.json', JSON.stringify(catalog, null, 2));
    await fs.unlink(filePath);
    res.json({ message: 'Каталог успешно загружен' });
  } catch (error) {
    res.status(500).json({ message: 'Ошибка: ' + error.message });
  }
});

app.post('/api/import/stock', upload.single('file'), async (req, res) => {
  try {
    const filePath = req.file.path;
    const workbook = xlsx.readFile(filePath);
    const sheetName = workbook.SheetNames[0];
    const data = xlsx.utils.sheet_to_json(workbook.Sheets[sheetName]);
    await fs.writeFile('data/stock.json', JSON.stringify(data, null, 2));
    await fs.unlink(filePath);
    res.json({ message: 'Остатки импортированы' });
  } catch (error) {
    res.status(500).json({ message: 'Ошибка: ' + error.message });
  }
});

app.get('/api/export/stock', async (req, res) => {
  try {
    const format = req.query.format || 'xls';
    const catalog = JSON.parse(await fs.readFile('data/catalog.json', 'utf8'));
    const stock = JSON.parse(await fs.readFile('data/stock.json', 'utf8'));
    const data = catalog.catalog.scooters_up_to_50cc.map(item => ({
      ...item,
      ...stock.find(s => s.article === item.article) || {}
    }));
    if (format === 'csv') {
      const csv = xlsx.utils.json_to_sheet(data);
      const buffer = xlsx.write({ SheetNames: ['Sheet1'], Sheets: { 'Sheet1': csv } }, { bookType: 'csv', type: 'buffer' });
      res.setHeader('Content-Type', 'text/csv');
      res.setHeader('Content-Disposition', 'attachment; filename=export_stock.csv');
      res.send(buffer);
    } else {
      const wb = xlsx.utils.book_new();
      const ws = xlsx.utils.json_to_sheet(data);
      xlsx.utils.book_append_sheet(wb, ws, 'Sheet1');
      const buffer = xlsx.write(wb, { bookType: 'xlsx', type: 'buffer' });
      res.setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      res.setHeader('Content-Disposition', 'attachment; filename=export_stock.xlsx');
      res.send(buffer);
    }
  } catch (error) {
    res.status(500).json({ message: 'Ошибка: ' + error.message });
  }
});

app.post('/api/set-schedule', (req, res) => {
  const { time, clients } = req.body;
  const [hours, minutes] = time.split(':');
  nodeSchedule.scheduleJob(${minutes} ${hours} * * *, () => {
    console.log(Отправка прайса клиентам ${clients} в ${time});
    // Добавить логику email с nodemailer
  });
  res.json({ message: 'Расписание установлено' });
});

app.listen(3000, () => console.log('Сервер запущен на 3000'));