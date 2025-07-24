namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Парсинг данных из Excel (пример для скутеров)
        return new Product([
            'category'     => $row['a'] ?? 'Мототехника',
            'name'         => $this->cleanName($row['a']),
            'dealer_price' => $this->parsePrice($row['d']),
            'retail_price' => $this->parsePrice($row['e']),
            'specs'        => $this->extractSpecs($row)
        ]);
    }

    private function cleanName($name)
    {
        // Удаление лишних символов в названии
        return preg_replace('/Скутер |Мотоцикл |Мопед /', '', $name);
    }

    private function parsePrice($value)
    {
        // Конвертация в числовой формат
        return is_numeric($value) ? floatval($value) : null;
    }

    private function extractSpecs($row)
    {
        // Извлечение характеристик в JSON
        return json_encode([
            'engine_volume' => $row['c'] ?? null,
            'power'         => $row['d'] ?? null,
            'max_speed'     => $row['e'] ?? null,
            // Другие характеристики
        ]);
    }
}