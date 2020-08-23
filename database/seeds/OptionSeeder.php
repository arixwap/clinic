<?php

use App\Option;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::insert([
            [
                'name' => 'qualification',
                'value' => 'Dokter Umum',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'qualification',
                'value' => 'Dokter Gigi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'qualification',
                'value' => 'Dokter Spesialis Anak',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'polyclinic',
                'value' => 'Poliklinik Umum',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'polyclinic',
                'value' => 'Poliklinik Gigi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'polyclinic',
                'value' => 'Poliklinik Anak',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
