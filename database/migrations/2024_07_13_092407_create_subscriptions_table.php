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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->integer('subs_id');
            $table->text('name')->nullable();
            $table->string('email', 111)->nullable();
            $table->string('phone', 111)->nullable();
            $table->text('category')->nullable();
            $table->integer('frequency')->nullable();
            $table->string('number_of_news', 111)->nullable();
            $table->integer('subs_auth_code');
            $table->integer('payment_status')->default(1);
            $table->integer('social_sheare')->default(1);
            $table->date('subscription_date');
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
        Schema::dropIfExists('subscriptions');
    }
};
