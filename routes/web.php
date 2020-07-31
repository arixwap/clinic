<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Untuk mengecek daftar Route URL. Gunakan command `php artisan route:list`
| Pastikan menggunakan terminal full screen agar tulisan list routenya tidak berantakan
|
*/

Auth::routes();
// ID url
Route::get('masuk', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('masuk', 'Auth\LoginController@login');
Route::get('daftar', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('daftar', 'Auth\RegisterController@register');
Route::post('keluar', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'HomeController@index')->name('home');
Route::get('home', function() {
    return redirect('/');
});

/**
 * Semua route yang didaftarkan dibawah ini hanya bisa diakses jika User login
 * Referensi : https://laravel.com/docs/routing#route-group-middleware
 */
Route::middleware('auth')->group(function () {

    Route::resource('patient', 'PatientController');
    // ID url
    Route::get('pasien', 'PatientController@index')->name('patient.index');
    Route::get('pasien/baru', 'PatientController@create')->name('patient.create');
    Route::get('pasien/ubah/{id}', 'PatientController@edit')->name('patient.edit');

    Route::resource('doctor', 'DoctorController');
    // ID url
    Route::get('dokter', 'DoctorController@index')->name('doctor.index');
    Route::get('dokter/baru', 'DoctorController@create')->name('doctor.create');
    Route::get('dokter/ubah/{id}', 'DoctorController@edit')->name('doctor.edit');

    Route::get('doctor/schedule/{id}', 'DoctorController@schedule')->name('schedule.index');
    Route::post('doctor/schedule/{id}', 'DoctorController@scheduleUpdate')->name('schedule.edit');
    // ID url
    Route::get('jadwal/dokter/{id}', 'DoctorController@schedule')->name('schedule.index');
    Route::post('jadwal/dokter/{id}', 'DoctorController@updateSchedule')->name('schedule.edit');

    Route::resource('polyclinic', 'PolyclinicController');
    // ID url
    Route::get('poliklinik', 'PolyclinicController@index')->name('polyclinic.index');

    Route::resource('qualification', 'QualificationController');
    // ID url
    Route::get('kualifikasi-dokter', 'QualificationController@index')->name('qualification.index');
});
