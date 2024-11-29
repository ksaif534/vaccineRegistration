<?php

namespace App\Jobs;

use App\Enumerators\UserStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckVaccinationDateExpiry implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        User::where('status', UserStatus::SCHEDULED)->chunkById(100, function (\Illuminate\Database\Eloquent\Collection $users) {
            foreach ($users as $user) {
                if (Carbon::parse($user->vaccination_date) < Carbon::now()) {
                    $user->update([
                        'status' => UserStatus::VACCINATED,
                    ]);
                }
            }
        });
    }
}
