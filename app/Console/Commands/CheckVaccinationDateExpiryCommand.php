<?php

namespace App\Console\Commands;

use App\Jobs\CheckVaccinationDateExpiry;
use Illuminate\Console\Command;

class CheckVaccinationDateExpiryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-vaccination-date-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to check whether a users vaccination date has expired or not. If expired, set user status to vaccinated';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        CheckVaccinationDateExpiry::dispatch();
    }
}
