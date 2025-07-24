namespace App\Services;

use App\Models\Product;
use App\Integrations\SupplierApi; // Интеграция с API поставщика

class InventoryService
{
    public function syncInventory()
    {
        $api = new SupplierApi(config('services.supplier.key'));
        $data = $api->getInventoryData();

        foreach ($data as $item) {
            Product::updateOrCreate(
                ['sku' => $item['sku']],
                [
                    'stock' => $item['quantity'],
                    'price' => $item['price'],
                    'updated_at' => now()
                ]
            );
        }
    }
}