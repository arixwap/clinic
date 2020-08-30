<?php

use App\Option;
use App\Role;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('slug', 'doctor')->first();
        $locale = config('app.faker_locale');
        $faker = Faker::create($locale);

        // Create array policlinic and qualification
        $polyclinics = Option::where('name', 'polyclinic')->get()->toArray();
        $qualifications = Option::where('name', 'qualification')->get()->toArray();
        $doctorList = array();
        foreach ( $polyclinics as $i => $polyclinic ) {
            $doctorList[$i] = [
                'polyclinic' => $polyclinic['value'],
                'qualification' => $qualifications[$i]['value']
            ];
        }

        for ( $i = 1; $i <= 5; $i++ ) {

            // Insert user role doctor
            $gender = $faker->randomElement(['Male', 'Female']);
            $user = $role->users()->create([
                'name' => 'Dr. '.$faker->name(strtolower($gender)),
                'email' => $faker->email,
                'password' => Hash::make('12345678'),
                'gender' => $gender,
                'birthplace' => $faker->city,
                'birthdate' => $faker->date('Y-m-d', '- 20 year'),
                'address' => $faker->address,
                'phone' => $faker->phoneNumber
            ]);

            // Create doctor with sync relation user
            $selectedDoctor = $faker->randomElement($doctorList);
            $user->doctor()->create([
                'qualification' => $selectedDoctor['qualification'],
                'polyclinic' => $selectedDoctor['polyclinic']
            ]);

            // Set working day and working times for schedule
            $workdays = $faker->randomElements(['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'], $faker->numberBetween(1, 7));
            $worktimes = array();
            for ( $x = 1; $x <= $faker->numberBetween(1, 2); $x++ ) {
                $date = $faker->dateTimeBetween('2020-01-01 08:00:00', '2020-01-01 20:00:00');
                $worktimes[] = [
                    'start' => Carbon::parse($date)->format('H:00:00'),
                    'end' => Carbon::parse($date)->addHours(3)->format('H:00:00')
                ];
            }

            // Create data schedules array
            $schedules = array();
            foreach ( $workdays as $day ) {
                foreach ( $worktimes as $time ) {
                    $schedules[] = [
                        'weekday' => $day,
                        'time_start' => $time['start'],
                        'time_end' => $time['end']
                    ];
                }
            }

            // Create doctor schedule with sync relation doctor
            $user->doctor->schedules()->createMany($schedules);
        }
    }
}
