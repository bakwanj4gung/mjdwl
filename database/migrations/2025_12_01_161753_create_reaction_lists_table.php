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
        Schema::create('reaction_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nama reaksi');
            $table->string('emoji')->comment('Emoji untuk reaksi');
            $table->text('note')->nullable()->comment('Catatan reaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reaction_lists');
    }
};
