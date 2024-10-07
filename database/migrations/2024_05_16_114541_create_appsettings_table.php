<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->text('website_title')->nullable();
            $table->text('footer_text')->nullable();
            $table->text('copy_right')->nullable();
            $table->string('time_zone', 200)->nullable();
            $table->string('ltl_rtl', 200)->nullable();
            $table->string('logo', 200)->nullable();
            $table->string('footer_logo', 200)->nullable();
            $table->string('favicon', 200)->nullable();
            $table->text('app_logo')->nullable();
            $table->string('mobile_menu_image', 200)->nullable();
            $table->tinyInteger('newstriker_status')->nullable();
            $table->tinyInteger('share_status')->nullable();
            $table->tinyInteger('preloader_status')->nullable();
            $table->tinyInteger('speed_optimization')->nullable();
            $table->tinyInteger('captcha')->nullable();
            $table->string('version', 50)->nullable();
            $table->updateCreatedBy();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
