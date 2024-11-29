<?php

namespace App\Console\Commands;

use App\Jobs\ScheduleVaccinationDate;
use App\Jobs\SendEmailNotification;
use App\Models\User;
use Illuminate\Console\Command;

class ScheduleVaccinationAndSendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule-vaccination-and-send-email {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule Vaccination Date & Send Email Notification';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ScheduleVaccinationDate::dispatchSync();

        SendEmailNotification::dispatch(User::find($this->argument('user')));
    }
}
