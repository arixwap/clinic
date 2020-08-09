<?php

use Illuminate\Database\Seeder;
use App\User;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Seeding - Dokter Umum
         */
        $user = User::create([
            'name' => 'Tirta Hudhi',
            'email' => 'tirta@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        // Create data doctor dengan sync relation user
        $user->doctor()->create([
            'full_name' => 'Dr. Tirta Mandira Hudhi',
            'gender' => 'Male',
            'birthplace' => 'Surakarta',
            'birthdate' => '1991-07-30',
            'address' => 'Surakarta, Jawa Tengah',
            'qualification' => 'Dokter Umum',
            'polyclinic' => 'Poliklinik Umum',
        ]);

        // Create data schedule dengan sync relation user doctor
        $user->doctor->schedule()->createMany([
            [
                'weekday' => 'mon',
                'time_start' => '09:00',
                'time_end' => '11:00'
            ],
            [
                'weekday' => 'mon',
                'time_start' => '19:00',
                'time_end' => '21:00'
            ],
            [
                'weekday' => 'tue',
                'time_start' => '09:00',
                'time_end' => '11:00'
            ],
            [
                'weekday' => 'tue',
                'time_start' => '19:00',
                'time_end' => '21:00'
            ],
            [
                'weekday' => 'wed',
                'time_start' => '09:00',
                'time_end' => '11:00'
            ],
            [
                'weekday' => 'wed',
                'time_start' => '19:00',
                'time_end' => '21:00'
            ],
            [
                'weekday' => 'thu',
                'time_start' => '09:00',
                'time_end' => '11:00'
            ],
            [
                'weekday' => 'thu',
                'time_start' => '19:00',
                'time_end' => '21:00'
            ],
            [
                'weekday' => 'fri',
                'time_start' => '09:00',
                'time_end' => '11:00'
            ],
            [
                'weekday' => 'fri',
                'time_start' => '19:00',
                'time_end' => '21:00'
            ],
        ]);


        /**
         * Seeding - Dokter Gigi
         */
        $user = User::create([
            'name' => 'Agus Kurniawan',
            'email' => 'agus@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        // Create data doctor dengan sync relation user
        $user->doctor()->create([
            'full_name' => 'Dr. Kadek Agus Kurniawan',
            'gender' => 'Male',
            'birthplace' => 'Denpasar',
            'birthdate' => '1987-01-30',
            'address' => 'Denpasar, Bali',
            'qualification' => 'Dokter Gigi',
            'polyclinic' => 'Poliklinik Gigi',
        ]);

        // Create data schedule dengan sync relation user doctor
        $user->doctor->schedule()->createMany([
            [
                'weekday' => 'fri',
                'time_start' => '18:00',
                'time_end' => '21:00',
                'limit' => '2'
            ],
            [
                'weekday' => 'sat',
                'time_start' => '18:00',
                'time_end' => '21:00',
                'limit' => '2'
            ]
        ]);
    }
}
