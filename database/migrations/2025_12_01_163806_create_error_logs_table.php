<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * References:
     * 1. https://docs.google.com/document/d/1mC9CA5IOC79T4BuWajPNQ_bTYF32STQZ7nUijEXVa28/edit?usp=sharing
     * 2. https://claude.ai/share/a8041676-470e-48da-8630-4bbcf6b66ba1
     * 3. https://laravel.com/docs/12.x/errors
     */
    public function up(): void
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('level', 50)
                ->comment('Tingkat keparahan (misal: ERROR, CRITICAL, WARNING)');
            $table->text('message')
                ->comment('Pesan error utama, (dari $e->getMessage())');
            $table->string('file')
                ->nullable()
                ->comment('Nama file tempat error terjadi (dari $e->getFile())');
            $table->integer('line')
                ->nullable()
                ->comment('Nomor baris tempat error terjadi (dari $e->getLine())');
            $table->longText('stack_trace')
                ->nullable()
                ->comment('Jejak tumpukan lengkap (dari $e->getTraceAsString())');
            $table->json('context')
                ->nullable()
                ->comment('Konteks saat error: user, input, ip, dan url disimpan di sini');
            $table->string('fingerprint', 64)
                ->nullable()
                ->comment('Hash (misal: MD5 dari file+line) untuk mengelompokkan error serupa');
            $table->timestamp('created_at')
                ->nullable()
                ->comment('Waktu error terjadi');
            
            // Indexes untuk performa query
            $table->index('level', 'error_logs_level_index');
            $table->index('created_at', 'error_logs_created_at_index');
            $table->index(['file', 'line'], 'error_logs_location_index');
            $table->index('fingerprint', 'error_logs_fingerprint_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_logs');
    }
};
