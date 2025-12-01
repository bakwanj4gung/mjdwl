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
        Schema::create('user_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->comment('ID user yang terhubung dengan schedule');
            $table->foreignId('schedule_id')
                ->constrained('schedules')
                ->onDelete('cascade')
                ->comment('ID schedule yang terhubung dengan user');
            $table->timestamps();

            // Tambahan: untuk menghindari duplikasi relasi
            $table->unique(['user_id', 'schedule_id'], 'user_schedule_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_schedule');
    }
};
