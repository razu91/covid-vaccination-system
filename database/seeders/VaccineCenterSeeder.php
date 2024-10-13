<?php

namespace Database\Seeders;

use App\Models\VaccineCenter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaccineCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("SET foreign_key_checks=0");

        VaccineCenter::truncate();

        VaccineCenter::insert([
            ['name' => 'Mohakhali Health Complex', 'location' => 'Mohakhali, Dhaka', 'daily_limit' => 250],
            ['name' => 'Gulshan Health Care', 'location' => 'Gulshan, Dhaka', 'daily_limit' => 300],
            ['name' => 'Uttara Sector 10 Clinic', 'location' => 'Uttara Sector 10, Dhaka', 'daily_limit' => 200],
            ['name' => 'Mirpur Health Center', 'location' => 'Mirpur, Dhaka', 'daily_limit' => 150],
            ['name' => 'Shyamoli General Hospital', 'location' => 'Shyamoli, Dhaka', 'daily_limit' => 180],
            ['name' => 'Dhanmondi Medical Center', 'location' => 'Dhanmondi, Dhaka', 'daily_limit' => 220],
            ['name' => 'Banani Community Clinic', 'location' => 'Banani, Dhaka', 'daily_limit' => 160],
            ['name' => 'Tejgaon Health Center', 'location' => 'Tejgaon, Dhaka', 'daily_limit' => 170],
            ['name' => 'Bashundhara Health Complex', 'location' => 'Bashundhara, Dhaka', 'daily_limit' => 240],
            ['name' => 'Jatrabari Medical Center', 'location' => 'Jatrabari, Dhaka', 'daily_limit' => 200]
        ]);
    }
}
