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
        Schema::create('reporters', function (Blueprint $table) {

            $table->id();
            $table->string('uuid');
            $table->string('reporter_id');
            $table->unsignedBigInteger('user_id');
            $table->string('email', 35);
            $table->string('mobile', 35)->nullable();
            $table->string('password', 191)->nullable();
            $table->string('name', 35)->nullable();
            $table->string('nick_name', 50)->nullable();
            $table->string('pen_name', 35)->nullable();
            $table->string('sex', 15)->nullable();
            $table->string('blood', 20)->nullable();
            $table->string('birth_date', 100)->nullable();
            $table->text('photo')->nullable();
            $table->text('address_one')->nullable();
            $table->text('address_two')->nullable();
            $table->text('about')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('zip', 100)->nullable();
            $table->string('verification_id_no', 100)->nullable();
            $table->string('verification_type', 100)->nullable();
            $table->integer('user_type')->nullable();
            $table->dateTime('login_time')->nullable();
            $table->dateTime('logout_time')->nullable();
            $table->string('ip', 15)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('post_ap_status')->default(0);
            $table->integer('department_id')->nullable();
            $table->string('designation', 200)->nullable();

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
        Schema::dropIfExists('reporters');
    }
};
