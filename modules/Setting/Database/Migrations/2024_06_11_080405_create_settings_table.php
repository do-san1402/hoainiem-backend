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
        Schema::create('settings', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->text('event');
            $table->longText('details');
            $table->updateCreatedBy();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id'); // Set 'id' as primary key without auto-increment
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
