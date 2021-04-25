<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
                    ->unsigned()
                    ->after('id')
                    ->nullable();
            $table->string('gender')
                    ->after('remember_token')
                    ->nullable();
            $table->string('birthplace')
                    ->after('gender')
                    ->nullable();
            $table->date('birthdate')
                    ->after('birthplace')
                    ->nullable();
            $table->longText('address')
                    ->after('birthdate')
                    ->nullable();
            $table->string('phone')
                    ->after('address')
                    ->nullable();
            $table->softDeletes();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(
                'role_id',
                'gender',
                'birthplace',
                'birthdate',
                'address',
                'phone',
                'deleted_at'
            );
        });
    }
}
