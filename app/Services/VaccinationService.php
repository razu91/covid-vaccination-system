<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class VaccinationService{

    /**
     * Retrieve the vaccination status of a user based on their NID.
     *
     * @param string $nid
     * @return array
     */
    public function getUserVaccinationStatus($nid)
    {

       // Generate a cache key based on the user's NID
       $cacheKey = 'user_vaccination_status_' . $nid;

       // Use the cache with a key, expire after 5 minutes, if not cached, execute the query
        return Cache::remember($cacheKey, 1 * 60, function () use ($nid) {

            // Find the user by their NID (National ID)
            $user = User::select('status', 'scheduled_date')->where('nid', $nid)->first();

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

        });
    }
}
