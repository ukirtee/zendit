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
        // Creates table for storing wind tower generators
        Schema::create('wtgs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., WTG1, WTG2
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wtgs');
    }
};
