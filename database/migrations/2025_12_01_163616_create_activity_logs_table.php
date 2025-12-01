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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('log_name')
                ->nullable()
                ->comment('Kategori log (misal: default, orders, system). Berguna untuk filtering log berdasarkan modul.');
            $table->text('description')
                ->comment('Penjelasan aktivitas yang dibaca manusia (misal: User X mengubah data Y).');
            $table->string('subject_type')
                ->nullable()
                ->comment('Nama Model/Class target yang diubah (Polymorphic Type). Misal: App\\Models\\Order.');
            $table->unsignedBigInteger('subject_id')
                ->nullable()
                ->comment('ID (PK) dari target yang diubah (Polymorphic ID).');
            $table->string('causer_type')
                ->nullable()
                ->comment('Nama Model/Class pelaku aksi (Polymorphic Type). Biasanya App\\Models\\User.');
            $table->unsignedBigInteger('causer_id')
                ->nullable()
                ->comment('ID pelaku yang melakukan aksi (misal: User ID). Jika null, mungkin aksi sistem.');
            $table->json('properties')
                ->nullable()
                ->comment('Menyimpan detail perubahan (attributes: old vs new) atau metadata tambahan dalam format JSON.');
            $table->timestamp('created_at')
                ->nullable()
                ->comment('Waktu aktivitas terjadi.');
            
            // Indexes untuk performa query
            $table->index('log_name', 'activity_logs_log_name_index');
            $table->index(['subject_type', 'subject_id'], 'activity_logs_subject_index');
            $table->index(['causer_type', 'causer_id'], 'activity_logs_causer_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
