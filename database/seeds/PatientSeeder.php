<?php

use Illuminate\Database\Seeder;
use App\Patient;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Patient::insert([
            [
                'full_name' => 'Wayan Subagia',
                'birthplace' => 'Klungkung',
                'birthdate' => '1963-01-11',
                'address' => 'Akah, Klungkung',
                'phone' => '081234567890',
                'gender' => 'Male',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'full_name' => 'Ketut Mellinggih',
                'birthplace' => 'Payangan',
                'birthdate' => '1958-04-01',
                'address' => 'Br Babadan, Ds Payangan',
                'phone' => '0361 434342',
                'gender' => 'Female',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'full_name' => 'Toni Desrentes',
                'birthplace' => 'Saint-Médard-en-Jalles, France',
                'birthdate' => '1997-08-17',
                'address' => 'Villa Cemadik, Br. Pujung Kaja, Tampaksiring',
                'phone' => '+33 45433212',
                'gender' => 'Male',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
