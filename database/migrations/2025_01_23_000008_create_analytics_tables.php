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
        // Table pour les lectures de musique
        Schema::create('analytics_music_plays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('music_id')->constrained('musics')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('ip_address');
            $table->text('user_agent')->nullable();
            $table->timestamp('played_at');
            $table->timestamps();

            $table->index(['music_id', 'played_at']);
            $table->index(['user_id', 'played_at']);
        });

        // Table pour les likes analytics
        Schema::create('analytics_music_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('music_id')->constrained('musics')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('ip_address');
            $table->timestamp('liked_at');
            $table->timestamps();

            $table->index(['music_id', 'liked_at']);
            $table->index(['user_id', 'liked_at']);
        });

        // Table pour les vues de musique
        Schema::create('analytics_music_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('music_id')->constrained('musics')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('ip_address');
            $table->text('user_agent')->nullable();
            $table->timestamp('viewed_at');
            $table->timestamps();

            $table->index(['music_id', 'viewed_at']);
            $table->index(['user_id', 'viewed_at']);
        });

        // Table pour les follows d'utilisateur
        Schema::create('analytics_user_follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('followed_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('followed_at');
            $table->timestamps();

            $table->index(['follower_id', 'followed_at']);
            $table->index(['followed_id', 'followed_at']);
        });

        // Table pour les créations de playlists
        Schema::create('analytics_playlist_creates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playlist_id')->constrained('playlists')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('created_at');
            $table->timestamp('tracked_at');

            $table->index(['user_id', 'created_at']);
        });

        // Table pour les recherches
        Schema::create('analytics_searches', function (Blueprint $table) {
            $table->id();
            $table->string('query');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('ip_address');
            $table->integer('results_count')->default(0);
            $table->timestamp('searched_at');
            $table->timestamps();

            $table->index(['query', 'searched_at']);
            $table->index(['user_id', 'searched_at']);
        });

        // Table pour les vues de pages
        Schema::create('analytics_page_views', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('ip_address');
            $table->text('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->timestamp('viewed_at');
            $table->timestamps();

            $table->index(['url', 'viewed_at']);
            $table->index(['user_id', 'viewed_at']);
        });

        // Table pour les préférences utilisateur
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('key');
            $table->text('value');
            $table->timestamps();

            $table->unique(['user_id', 'key']);
            $table->index(['user_id']);
        });

        // Table pour les consentements de cookies
        Schema::create('cookie_consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('ip_address');
            $table->text('user_agent')->nullable();
            $table->json('consent_data');
            $table->timestamp('consented_at');
            $table->timestamps();

            $table->index(['user_id', 'consented_at']);
            $table->index(['ip_address', 'consented_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cookie_consents');
        Schema::dropIfExists('user_preferences');
        Schema::dropIfExists('analytics_page_views');
        Schema::dropIfExists('analytics_searches');
        Schema::dropIfExists('analytics_playlist_creates');
        Schema::dropIfExists('analytics_user_follows');
        Schema::dropIfExists('analytics_music_views');
        Schema::dropIfExists('analytics_music_likes');
        Schema::dropIfExists('analytics_music_plays');
    }
};
