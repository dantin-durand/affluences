<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 9; $i++) {
            $email = $faker->email;

            $selected_day = $faker->dateTimeBetween($startDate = 'now', $endDate = '1 years', $timezone = null)->format('Y-m-d');

            $selected_hour = $faker->numberBetween($min = Config::get('information.reservation_timetable.0'), $max = Config::get('information.reservation_timetable.1'));

            $token = sha1(mt_rand(1, 90000) . 'SALT');

            DB::table('affluences')->insert([
                'email' => $email,
                'selected_day' => $selected_day,
                'selected_hour' => $selected_hour,
                'token' => $token,
            ]);
        }
    }
}
