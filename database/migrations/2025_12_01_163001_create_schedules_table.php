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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maker_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->comment('ID pembuat schedule');
            $table->foreignId('priority_id')
                ->constrained('priorities')
                ->onDelete('cascade')
                ->comment('ID prioritas schedule');
            $table->foreignId('color_id')
                ->nullable()
                ->constrained('colors')
                ->onDelete('set null')
                ->comment('Warna custom schedule (opsional)');
            $table->enum('visibility', ['private', 'public'])
                ->default('private')
                ->comment('Visibilitas schedule');
            $table->boolean('shareable')
                ->default(false)
                ->comment('Apakah schedule dapat dibagikan');
            $table->string('title')->comment('Judul schedule');
            $table->timestamp('start')->comment('Waktu mulai schedule');
            $table->timestamp('end')->comment('Waktu selesai schedule');
            $table->enum('status', ['pending', 'completed', 'canceled'])
                ->default('pending')
                ->comment('Status schedule');
            $table->text('note')->nullable()->comment('Catatan schedule');
            $table->softDeletes()->comment('Soft delete untuk schedule');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
