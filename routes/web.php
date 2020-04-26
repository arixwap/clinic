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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/**
 * Semua route yang didaftarkan dibawah ini hanya bisa diakses jika User login
 * Referensi : https://laravel.com/docs/routing#route-group-middleware
 */
Route::middleware('auth')->group(function () {

    // Route yang mengambil file controller - app/Http/Controllers/PatientController.php
    Route::resource('/patient', 'PatientController');
    Route::resource('/doctor', 'DoctorController');

});
