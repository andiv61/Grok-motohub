namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PriceListExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::all([
            'sku', 'name', 'dealer_price', 'retail_price', 'stock'
        ]);
    }

    public function headings(): array
    {
        return ['Артикул', 'Наименование', 'Дилерская цена', 'Розничная цена', 'Остаток'];
    }
}