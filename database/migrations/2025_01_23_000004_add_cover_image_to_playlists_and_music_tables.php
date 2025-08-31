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
        Schema::table('playlists', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('description');
        });

        Schema::table('musics', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('playlists', function (Blueprint $table) {
            $table->dropColumn('cover_image');
        });

        Schema::table('musics', function (Blueprint $table) {
            $table->dropColumn('cover_image');
        });
    }
};
