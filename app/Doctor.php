<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Doctor extends Model
{
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
     * Arix Wap - Note
     *
     * Tambahkan daftar Kualifikasi Dokter disini
     * Jika ada perubahan nama kualifikasi, ubah namanya saja. JANGAN mengubah valuenya!
     * karena akan berpengaruh ke data dokter lain jika data dokter yang tersimpan sudah banyak
     */
    protected static $qualifications = [
        'umum'      => 'Dokter Umum',
        'spog'      => 'Dokter Spesialis Obstetri dan Ginekologi',
        'sptht'     => 'Dokter Spesialis Telinga Hidung Tenggorok',
        'spkg'      => 'Dokter Gigi',
        'sppd'      => 'Dokter Spesialis Ahli Penyakit Dalam',
        'spa'       => 'Dokter Spesialis Anak',
    ];

    public static function getQualifications() {
        return Doctor::$qualifications;
    }

    /**
     * Relationship tabel Doctors ke tabel Users
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
}
