<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\VaccineSchedule;
use App\Notifications\SendVaccineScheduleNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendVaccineScheduleMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:vaccine-schedule-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send vaccine schedule mail to user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("Scheduler started");

        $users = User::whereDate('scheduled_date', now()->addDay()->toDateString())->get();

        Log::info("Users found: " . $users->count());

        foreach ($users as $user) {
            $user->notify(new SendVaccineScheduleNotification($user));
        }

    }
}
