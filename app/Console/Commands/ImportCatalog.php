namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;

class ImportCatalog extends Command
{
    protected $signature = 'catalog:import {file}';
    protected $description = 'Import products from XLS file';

    public function handle()
    {
        $file = $this->argument('file');
        
        Excel::import(new ProductImport, $file);
        
        $this->info('Catalog imported successfully!');
    }
}