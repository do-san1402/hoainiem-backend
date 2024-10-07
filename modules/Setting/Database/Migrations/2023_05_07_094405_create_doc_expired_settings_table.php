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
        Schema::create('doc_expired_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('primary_expiration_alert')->comment('Primary Expiration Alert in Days');            
            $table->integer('secondary_expiration_alert')->comment('Secondary Expiration Alert in Days');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_expired_settings');
    }
};
