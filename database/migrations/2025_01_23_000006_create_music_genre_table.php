<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('music_genre', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('music_id');
            $table->unsignedBigInteger('music_genre_id');
            $table->timestamps();

            $table->foreign('music_id')->references('id')->on('musics')->onDelete('cascade');
            $table->foreign('music_genre_id')->references('id')->on('music_genres')->onDelete('cascade');
            $table->unique(['music_id', 'music_genre_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music_genre');
    }
};
