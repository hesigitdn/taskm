protected function schedule(Schedule $schedule) {
    $schedule->command('notify:upcoming-tasks')->daily();
    $schedule->command('reminder:send')->dailyAt('08:00');
}

