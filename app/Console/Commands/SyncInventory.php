namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\InventoryService;

class SyncInventory extends Command
{
    protected $signature = 'inventory:sync';
    protected $description = 'Sync product inventory and prices';

    public function handle(InventoryService $service)
    {
        $service->syncInventory();
        $this->info('Inventory synced successfully!');
    }
}