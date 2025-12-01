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
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reaction_list_id')
                ->constrained('reaction_lists')
                ->onDelete('cascade')
                ->comment('ID jenis reaksi dari reaction_lists');
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->comment('ID user yang memberikan reaksi');
            $table->unsignedBigInteger('parent_id')
                ->nullable()
                ->comment('ID parent (schedule_id atau comment_id)');
            $table->enum('type', ['schedule', 'comment'])
                ->comment('Tipe parent: schedule atau comment');
            $table->text('content')->comment('Konten reaksi (jika ada text tambahan)');
            $table->timestamps();
            
            // Index untuk performa query
            $table->index('parent_id', 'reactions_parent_index');
            
            // Tambahan: mencegah user memberikan reaksi yang sama 2x
            $table->unique(['user_id', 'reaction_list_id', 'parent_id', 'type'], 'reaction_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
