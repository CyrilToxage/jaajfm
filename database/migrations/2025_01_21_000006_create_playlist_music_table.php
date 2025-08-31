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
        Schema::create('playlist_music', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playlist_id')->constrained()->onDelete('cascade');
            $table->foreignId('music_id')->constrained('musics')->onDelete('cascade');
            $table->integer('order')->default(0); // Ordre dans la playlist
            $table->timestamps();

            // Empêcher les doublons
            $table->unique(['playlist_id', 'music_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_music');
    }
};
