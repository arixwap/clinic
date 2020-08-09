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
            $table->foreignId('schedule_id');
            $table->foreignId('patient_id');
            $table->foreignId('doctor_id');
            $table->foreignId('user_id');
            $table->tinyInteger('number');
            $table->date('date');
            $table->time('time_start', 0);
            $table->time('time_end', 0);
            $table->string('bpjs')->nullable();
            $table->text('description')->nullable();
            $table->text('doctor_note')->nullable();
            $table->boolean('new_patient')->default(false);
            $table->boolean('is_done')->default(false)->comment('Is patient already done checkup or not');
            $table->timestamps();
            $table->softDeletes();
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
