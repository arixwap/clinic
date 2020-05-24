<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationship 1 to 1 - tabel `users` ke tabel `doctors`
     */
    public function doctor()
    {
        /**
         * hasOne digunakan jika ada relation tabel 1 to 1, dimana tabel ini merupakan sumber dari relation
         * Misalnya :
         * tabel User boleh tidak memiliki data di Tabel Doctor
         *
         * Laravel otomatis mengetahui kolom 'user_id' di tabel Doctor merupakan foreign key dari tabel ini
         * Itulah sebabnya mengapa penamaan Model, Tabel dan Kolom tabel harus menggunakan bahasa inggris
         */
        return $this->hasOne('App\Doctor'); // Pemanggilan file dari directory / folder
    }

    /**
     * Check jika User adalah Doctor atau bukan
     * Return true / false
     */
    public function isDoctor()
    {
        return $this->doctor;
    }
}
