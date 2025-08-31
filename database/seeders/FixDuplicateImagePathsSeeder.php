<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Music;
use Illuminate\Support\Facades\DB;

class FixDuplicateImagePathsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Corriger les chemins d'images qui contiennent des doublons
        $musics = Music::whereNotNull('cover_image')->get();

        foreach ($musics as $music) {
            $coverImage = $music->cover_image;

            // Si le chemin contient 'storage/uploads/covers/storage/uploads/covers/'
            if (str_contains($coverImage, 'storage/uploads/covers/storage/uploads/covers/')) {
                $correctedPath = str_replace('storage/uploads/covers/storage/uploads/covers/', 'uploads/covers/', $coverImage);
                $music->cover_image = $correctedPath;
                $music->save();
                $this->command->info("Corrigé: {$coverImage} -> {$correctedPath}");
            }

            // Si le chemin contient 'uploads/covers/uploads/covers/'
            elseif (str_contains($coverImage, 'uploads/covers/uploads/covers/')) {
                $correctedPath = str_replace('uploads/covers/uploads/covers/', 'uploads/covers/', $coverImage);
                $music->cover_image = $correctedPath;
                $music->save();
                $this->command->info("Corrigé: {$coverImage} -> {$correctedPath}");
            }
        }

        $this->command->info('Chemins d\'images corrigés pour ' . $musics->count() . ' musiques.');
    }
}
