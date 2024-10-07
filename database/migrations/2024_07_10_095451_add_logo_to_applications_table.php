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
        Schema::table('applications', function (Blueprint $table) {
            $table->string('footer_logo', 200)->nullable();
            $table->text('app_logo')->nullable();
            $table->string('mobile_menu_image', 200)->nullable();
            $table->string('time_zone', 200)->nullable();
            $table->text('copy_right')->nullable();
            $table->tinyInteger('newstriker_status')->nullable();
            $table->tinyInteger('preloader_status')->nullable();
            $table->tinyInteger('speed_optimization')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            //
        });
    }
};
