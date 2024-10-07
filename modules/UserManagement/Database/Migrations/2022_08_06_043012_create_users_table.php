<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->unsignedBigInteger('user_type_id');
            $table->string('full_name');
            $table->string('user_name');
            $table->string('profile_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('signature')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('contact_no')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('attempt')->nullable();
            $table->string('recovery_code')->nullable();
            $table->boolean('is_active')->default(0);
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
        Schema::dropIfExists('users');
    }
};
