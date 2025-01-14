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
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade'); // Foreign key to Tasks table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to Users table
            $table->decimal('hours_logged', 8, 2);
            $table->date('log_date');
            $table->timestamps();
        });

        // Adding indexes
        Schema::table('timesheets', function (Blueprint $table) {
            $table->index('task_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timesheets');
    }
};
