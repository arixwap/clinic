<?php

use App\Role;
use App\User;
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

        // Seeding - Dokter Umum
        $user = $role->users()->create([
            'name' => 'Dr. Tirta Mandira Hudhi',
            'email' => 'tirta@clinic.test',
            'password' => Hash::make('12345678'),
            'gender' => 'Male',
            'birthplace' => 'Surakarta',
            'birthdate' => '1991-07-30',
            'address' => 'Surakarta, Jawa Tengah'
        ]);

        // Create data doctor dengan sync relation user
        $user->doctor()->create([
            'qualification' => 'Dokter Umum',
            'polyclinic' => 'Poliklinik Umum'
        ]);

        // Create data schedule dengan sync relation user doctor
        $user->doctor->schedules()->createMany([
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
            ]
        ]);
        // --

        // Seeding - Dokter Gigi
        $user = $role->users()->create([
            'name' => 'Dr. Kadek Agus Kurniawan',
            'email' => 'agus@clinic.test',
            'password' => Hash::make('12345678'),
            'gender' => 'Male',
            'birthplace' => 'Denpasar',
            'birthdate' => '1987-01-30',
            'address' => 'Denpasar, Bali'
        ]);

        // Create data doctor dengan sync relation user
        $user->doctor()->create([
            'qualification' => 'Dokter Gigi',
            'polyclinic' => 'Poliklinik Gigi'
        ]);

        // Create data schedule dengan sync relation user doctor
        $user->doctor->schedules()->createMany([
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
        // --
    }
}
