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
        Schema::create('milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wtg_id')->constrained('wtgs')->onDelete('cascade'); // Foreign key to wtg table
            $table->string('name'); // e.g., Blade 1, Nacelle, etc.
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });

         // Adding indexes
         Schema::table('milestones', function (Blueprint $table) {
            $table->index('wtg_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milestones');
    }
};
