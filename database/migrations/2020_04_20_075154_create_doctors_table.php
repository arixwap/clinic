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
            $table->foreignId('user_id');                   // Foreign key tabel Users
            $table->string('polyclinic')->nullable();
            $table->string('qualification')->nullable();    // Kualifikasi Dokter (Umum, Gigi, SpOG, etc)
            $table->string('university')->nullable();
            $table->string('str')->nullable();              // Nomor Surat Tanda Registrasi Dokter
            $table->date('str_start_date')->nullable();     // Tanggal STR Ditetapkan
            $table->date('str_end_date')->nullable();       // Tanggal STR Berlaku Sampai
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
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
