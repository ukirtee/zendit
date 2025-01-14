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
        Schema::create('task_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->unique()->constrained('tasks')->onDelete('cascade');
            $table->decimal('actual_hours', 8, 2)->default(0.00);
            $table->decimal('variance', 8, 2)->default(0.00);
            $table->timestamp('last_updated')->useCurrent();
            $table->timestamps();
        });

        // Adding indexes
        Schema::table('task_statistics', function (Blueprint $table) {
            $table->index('task_id'); // Index for foreign key relationship
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_statistics');
    }
};
