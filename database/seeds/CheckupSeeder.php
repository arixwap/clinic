<?php

use App\Checkup;
use App\Patient;
use App\Schedule;
use App\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CheckupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Create dummy checkup from existing patient
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        $patients = Patient::all();
        $faker = Faker::create();

        foreach ( $patients as $patient ) {

            $checkups = array();
            $loop = $faker->numberBetween(1, 10);

            // Create random checkup data
            for ( $i = 1; $i <= $loop; $i++ ) {

                $checkup = new Checkup([
                    'number' => 1,
                    'date' => $faker->dateTimeBetween('-1 years', '+ 3 month'),
                    'description' => $faker->sentence()
                ]);

                // Random use bpjs or not
                if ( $faker->boolean(3) ) $checkup->bpjs = $faker->ean13();

                // Get random schedule data
                $schedule = Schedule::all()->random();

                // Associate relationship
                $checkup->schedule()->associate($schedule);
                $checkup->doctor()->associate($schedule->doctor);
                $checkup->user()->associate($user);

                // Assign schedule time to checkup time
                $checkup->time_start = $schedule->time_start;
                $checkup->time_end = $schedule->time_end;

                $checkups[] = $checkup;
            }

            $patient->checkups()->saveMany($checkups);
        }
    }
}
