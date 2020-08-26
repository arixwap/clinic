<?php

use App\Patient;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array();
        $locale = config('app.faker_locale');
        $faker = Faker::create($locale);
        $loop = $faker->numberBetween(3, 10);

        for ( $i = 1; $i <= $loop; $i++ ) {
            $gender = $faker->randomElement(['Male', 'Female']);
            $data[] = [
                'name' => $faker->name(strtolower($gender)),
                'birthplace' => $faker->city,
                'birthdate' => $faker->date('Y-m-d', 'now'),
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'gender' => $gender,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        Patient::insert($data);
    }
}
