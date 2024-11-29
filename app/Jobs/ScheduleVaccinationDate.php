<?php

namespace App\Jobs;

use App\Enumerators\UserStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ScheduleVaccinationDate implements ShouldQueue
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
        $last24Hours = Carbon::now()->subHours(24);

        $availableNumberOfDailyUsersForSchedule = User::where('status', UserStatus::NOT_SCHEDULED)
            ->where('created_at', '>=', $last24Hours)
            ->count();

        $usersToSchedule = User::where('status', UserStatus::NOT_SCHEDULED)
            ->with('vaccine_center')
            ->orderBy('created_at', 'asc')
            ->chunkById(100, function (\Illuminate\Database\Eloquent\Collection $usersToSchedule) use ($availableNumberOfDailyUsersForSchedule) {

                foreach ($usersToSchedule as $user) {
                    if ($availableNumberOfDailyUsersForSchedule < 0) {
                        break;
                    }

                    if ($user->vaccine_center->daily_limit >= $availableNumberOfDailyUsersForSchedule) {
                        $user->update([
                            'status' => UserStatus::SCHEDULED,
                            'vaccination_date' => Carbon::now()->addDays(rand(0, 30)),
                        ]);
                        $availableNumberOfDailyUsersForSchedule--;
                    }
                }

            });
    }
}
