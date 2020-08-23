<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetForeignKeyToCheckupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkups', function (Blueprint $table) {
            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checkups', function (Blueprint $table) {
            $table->dropForeign('checkups_doctor_id_foreign');
            $table->dropForeign('checkups_patient_id_foreign');
            $table->dropForeign('checkups_schedule_id_foreign');
            $table->dropForeign('checkups_user_id_foreign');
        });
    }
}
