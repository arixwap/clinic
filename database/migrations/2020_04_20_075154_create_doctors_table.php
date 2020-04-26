<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');                   // Foreign key ke tabel Users
            $table->string('full_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('birthplace')->nullable();
            $table->date('birthdate')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('university')->nullable();
            $table->string('qualification')->nullable();    // Kualifikasi Dokter (Umum, Gigi, SpOG, etc)
            $table->string('str')->nullable();              // Nomor Surat Tanda Registrasi Dokter
            $table->date('str_start_date')->nullable();     // Tanggal STR Ditetapkan
            $table->date('str_end_date')->nullable();       // Tanggal STR Berlaku Sampai
            $table->text('photo_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
