protected function schedule(Schedule $schedule) {
    $schedule->command('reminder:send')->dailyAt('08:00');
}

