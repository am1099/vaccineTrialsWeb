<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateVolunteersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->string('email', 100)->primary();
            $table->string('fullname', 100);
            $table->string('gender', 45)->nullable();
            $table->integer('age');
            $table->longText('address')->nullable();
            $table->longText('health_condition')->nullable();
            $table->longText('passwordHash');
            $table->string('vaccineGroup', 45)->nullable();
            $table->float('dose')->nullable();
            $table->string('infected', 45)->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteers');
    }
}
