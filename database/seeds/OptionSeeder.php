<?php

use Illuminate\Database\Seeder;
use App\Option;

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
            ],
            [
                'name' => 'qualification',
                'value' => 'Dokter Gigi',
            ],
            [
                'name' => 'qualification',
                'value' => 'Dokter Spesialis Anak',
            ],
            [
                'name' => 'polyclinic',
                'value' => 'Poliklinik Umum',
            ],
            [
                'name' => 'polyclinic',
                'value' => 'Poliklinik Gigi',
            ],
            [
                'name' => 'polyclinic',
                'value' => 'Poliklinik Anak',
            ],
        ]);
    }
}
