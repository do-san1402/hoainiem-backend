<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_settings', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('salt');
            $table->integer('min_length');
            $table->integer('max_lifetime');
            $table->string('password_complexcity');
            $table->string('password_history');
            $table->string('lock_out_duration');
            $table->string('session_idle_logout_time');
            $table->updateCreatedBy();
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
        Schema::dropIfExists('password_settings');
    }
};
