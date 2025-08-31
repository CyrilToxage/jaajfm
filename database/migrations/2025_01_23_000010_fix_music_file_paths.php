<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Corriger les chemins des fichiers audio qui commencent par 'music/' au lieu de 'uploads/music/'
        DB::table('musics')
            ->where('file_path', 'like', 'music/%')
            ->update([
                    'file_path' => DB::raw("CONCAT('uploads/', file_path)")
                ]);

        // Corriger les chemins des images de couverture qui commencent par 'covers/' au lieu de 'uploads/covers/'
        DB::table('musics')
            ->where('cover_image', 'like', 'covers/%')
            ->update([
                    'cover_image' => DB::raw("CONCAT('uploads/', cover_image)")
                ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Annuler les corrections
        DB::table('musics')
            ->where('file_path', 'like', 'uploads/music/%')
            ->update([
                    'file_path' => DB::raw("SUBSTRING(file_path, 9)") // Enlever 'uploads/'
                ]);

        DB::table('musics')
            ->where('cover_image', 'like', 'uploads/covers/%')
            ->update([
                    'cover_image' => DB::raw("SUBSTRING(cover_image, 9)") // Enlever 'uploads/'
                ]);
    }
};
