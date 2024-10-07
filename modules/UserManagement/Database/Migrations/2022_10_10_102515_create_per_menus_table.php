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
        Schema::create('per_menus', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->bigInteger('parentmenu_id')->nullable();
            $table->bigInteger('lable');
            $table->string('menu_name');
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
        Schema::dropIfExists('per_menus');
    }
};
