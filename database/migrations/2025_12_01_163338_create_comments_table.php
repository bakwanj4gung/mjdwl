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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->comment('ID user yang menulis komentar');
            $table->unsignedBigInteger('parent_id')
                ->nullable()
                ->comment('ID parent (schedule_id atau comment_id untuk reply)');
            $table->enum('type', ['schedule', 'comment'])
                ->comment('Tipe parent: schedule atau comment');
            $table->text('content')->comment('Isi komentar');
            $table->timestamps();
            $table->softDeletes()->comment('Soft delete penting untuk moderasi');
            
            // Index untuk performa query
            $table->index('parent_id', 'comments_parent_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
