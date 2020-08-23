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

Route::get('/', 'HomeController@index')->name('home');

// Authentication Route
Auth::routes([
    'register' => false, // Remove route register from public
    'verify' => false,
]);
// Localizing URL
Route::get(__('login'), 'Auth\LoginController@showLoginForm')->name('login');
Route::post(__('login'), 'Auth\LoginController@login');
Route::post(__('logout'), 'Auth\LoginController@logout')->name('logout');


/**
 * Semua route yang didaftarkan dibawah ini hanya bisa diakses jika User login
 * Referensi : https://laravel.com/docs/routing#route-group-middleware
 */
Route::middleware('auth')->group( function() {

    Route::get('ajax', 'AjaxController@index')->name('ajax');

    // Resource Route Role
    Route::resource(__('role'), 'RoleController', ['names' => 'role']);

    // Resource Route User
    Route::resource(__('user'), 'UserController', ['names' => 'user']);

    // Resource Route Patient
    Route::resource(__('patient'), 'PatientController', ['names' => 'patient']);

    // Resource Route Doctor
    Route::resource(__('doctor'), 'DoctorController', ['names' => 'doctor']);
    Route::get(__('doctor').'/'.__('schedule').'/{id}', 'DoctorController@schedule')->name('schedule.index');
    Route::post(__('doctor').'/'.__('schedule').'/{id}', 'DoctorController@updateSchedule')->name('schedule.edit');

    Route::resource(__('polyclinic'), 'PolyclinicController', ['names' => 'polyclinic']);

    Route::resource(__('qualification'), 'QualificationController', ['names' => 'qualification']);

    // Resource Route Checkup
    Route::resource(__('checkup'), 'CheckupController', ['names' => 'checkup']);
});
