<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'gender',
        'birthplace',
        'birthdate',
        'address',
        'phone',
        'university',
        'qualification',
        'str',
        'str_start_date',
        'str_end_date',
        'photo_url',
    ];

    /**
     * Relationship 1 to 1 - tabel `doctors` ke tabel `users`
     */
    public function user()
    {
        /**
         * belongsTo digunakan jika ada relation tabel 1 to 1, dimana tabel ini merupakan target dari relation
         * Misalnya :
         * tabel Doctor pasti memiliki data di Tabel User,
         * namun tabel User belum tentu memiliki data di tabel Doctor
         *
         * Laravel otomatis mengetahui kolom 'user_id' merupakan foreign key dari
         * relationship tabel Doctors dengan Users
         *
         * Itulah sebabnya mengapa penamaan Model, Tabel dan Kolom tabel harus menggunakan bahasa inggris
         */
        return $this->belongsTo('App\User'); // Pemanggilan file dari directory / folder
    }

    /**
     * Relationship 1 to many - tabel `doctors` ke tabel `schedules`
     */
    public function schedule()
    {
        return $this->hasMany('App\Schedule');
    }
}
