<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule as ScheduleDay;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

$users = User::chunkById(20, function (\Illuminate\Database\Eloquent\Collection $users) {
    foreach ($users as $user) {
        Schedule::command('schedule-vaccination-and-send-email '. $user->id)->dailyAt('21:00')->days([ScheduleDay::SUNDAY, ScheduleDay::MONDAY, ScheduleDay::TUESDAY, ScheduleDay::WEDNESDAY, ScheduleDay::THURSDAY]);
    }
});

Schedule::command('check-vaccination-date-expiry')->dailyAt('00:00');
