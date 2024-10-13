<?php

namespace App\Services;

use App\Models\User;
use App\Models\VaccineCenter;

class UserService
{
    /**
     * Retrieve all available vaccine centers for displaying
     * on the registration form.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function registerFormView()
    {
        // Get all vaccine centers
        return VaccineCenter::all();
    }


    /**
     * Register the user with the provided information and assign a vaccination date.
     *
     * @param array $request
     * @return \App\Models\User
     */
    public function registerUserInfo($request)
    {
        $vaccine_center = VaccineCenter::find($request['vaccine_center']);

        $schedule_date = $this->getNextAvailableVaccinationDate($vaccine_center);

        //Create User
        $user = User::create([
            'name' => $request['name'],
            'nid' => $request['nid'],
            'email'=> $request['email'],
            'phone'=> $request['phone'],
            'scheduled_date' => $schedule_date,
            'vaccine_center_id' => $request['vaccine_center'],
        ]);

        return $user;
    }

    /**
     * Get the next available vaccination date for the given vaccine center.
     *
     * This function skips weekends and ensures that the daily limit of the center
     * is not exceeded before assigning a date.
     *
     * @param \App\Models\VaccineCenter $vaccine_center
     * @return \Illuminate\Support\Carbon
     */
    private function getNextAvailableVaccinationDate($vaccine_center)
    {
        $today = today();

        while(true){

            if($today->isWeekend()){
                $today->addDay();
                continue;
            }

            $scheduleDateDailyCount = User::where('vaccine_center_id',$vaccine_center->id)
                                            ->whereDate('scheduled_date',$today->toDateString())
                                            ->count();

            if($vaccine_center->daily_limit > $scheduleDateDailyCount){
                return $today;
            }

            $today->addDay();
        }
    }

}
