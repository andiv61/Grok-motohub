protected function schedule(Schedule $schedule)
{
    $schedules = ExportSchedule::where('is_active', true)->get();
    
    foreach ($schedules as $job) {
        $schedule->command("export:pricelist {$job->id}")
            ->cron($this->convertScheduleToCron($job));
    }
}

private function convertScheduleToCron($job)
{
    // Конвертация расписания в cron-формат
    return "{$job->minute} {$job->hour} * * {$job->days}";
}