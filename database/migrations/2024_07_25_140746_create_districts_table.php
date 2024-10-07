<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Division;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Division::class)->constrained();
            $table->string('name', 255);
            $table->string('bn_name', 255);
            $table->string('lat', 255);
            $table->string('lon', 255);
            $table->string('url', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
