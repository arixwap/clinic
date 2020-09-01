<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->unsigned()->nullable();
            $table->foreignId('patient_id');
            $table->foreignId('doctor_id');
            $table->foreignId('user_id');
            $table->integer('number');
            $table->date('date');
            $table->time('time_start', 0);
            $table->time('time_end', 0);
            $table->string('bpjs')->nullable();
            $table->text('description')->nullable();
            $table->text('doctor_note')->nullable();
            $table->boolean('new_patient')->default(false);
            $table->boolean('is_done')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('SET NULL');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('CASCADE');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkups');
    }
}
