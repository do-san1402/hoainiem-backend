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
        Schema::create('news_routings', function (Blueprint $table) {
            $table->string('news_id', 50)->primary();
            $table->string('uuid');
            $table->text('table_name')->nullable();
            $table->string('routing_id', 50)->nullable();
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
        Schema::dropIfExists('news_routings');
    }
};
