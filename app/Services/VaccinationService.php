<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class VaccinationService{

    /**
     * Retrieve the vaccination status of a user based on their NID.
     *
     * @param string $nid
     * @return array
     */
    public function getUserVaccinationStatus($nid){

       // Find the user by their NID (National ID)
       $user = User::where('nid',$nid)->first();

       // Default status for users not found in the system
       $status = "Not Registered";

       // If the user exists, determine their vaccination status
       if ($user) {

        if ($user->status === 'vaccinated') {

            $status = "Vaccinated";

        } elseif ($user->status === 'scheduled') {

            // Parse the scheduled vaccination date
            $scheduledDate = Carbon::parse($user->scheduled_date);

            // Check if the scheduled date is today or in the past
            if ($scheduledDate->isToday()) {
                $status = "Scheduled: " . $scheduledDate->format('Y-m-d');
            } elseif ($scheduledDate->isPast()) {
                // If the date has passed, assume the user is vaccinated
                $status = "Vaccinated";
            } else {
                $status = "Scheduled: " . $scheduledDate->format('Y-m-d');
            }

        } else {

            $status = "Not Scheduled";

        }
       }

       // Return the vaccination status as an array
       return [
        'status' => $status
       ];

    }
}
