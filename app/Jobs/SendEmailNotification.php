<?php

namespace App\Jobs;

use App\Mail\SendEmailAfterVaccineSchedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\{Mail};
use App\Models\{User,VaccineCenter};

class SendEmailNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $vaccineCenter = VaccineCenter::where('id',$this->user->vaccine_center_id)->first();

        Mail::to($this->user->email)->send(new SendEmailAfterVaccineSchedule($this->user, $vaccineCenter));
    }
}
