namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PriceListExport;
use App\Models\ExportSchedule;

class ExportPriceList extends Command
{
    protected $signature = 'export:pricelist {schedule}';
    protected $description = 'Export price list to XLS';

    public function handle()
    {
        $scheduleId = $this->argument('schedule');
        $schedule = ExportSchedule::find($scheduleId);
        
        $fileName = "pricelist-{$schedule->client}-".now()->format('Ymd').'.xlsx';
        
        Excel::store(new PriceListExport, $fileName);
        
        // Отправка файла клиенту (пример)
        \Mail::to($schedule->email)->send(new PriceListMail($fileName));
        
        $this->info("Price list exported for {$schedule->client}");
    }
}