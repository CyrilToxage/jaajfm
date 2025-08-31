<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Music;

class FixImagePaths extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:image-paths';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Corriger les chemins d\'images dupliqués dans la base de données';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Correction des chemins d\'images...');

        $musics = Music::whereNotNull('cover_image')->get();
        $fixedCount = 0;

        foreach ($musics as $music) {
            $coverImage = $music->cover_image;
            $originalPath = $coverImage;

            // Si le chemin contient 'storage/uploads/covers/storage/uploads/covers/'
            if (str_contains($coverImage, 'storage/uploads/covers/storage/uploads/covers/')) {
                $coverImage = str_replace('storage/uploads/covers/storage/uploads/covers/', 'uploads/covers/', $coverImage);
                $fixedCount++;
            }

            // Si le chemin contient 'uploads/covers/uploads/covers/'
            elseif (str_contains($coverImage, 'uploads/covers/uploads/covers/')) {
                $coverImage = str_replace('uploads/covers/uploads/covers/', 'uploads/covers/', $coverImage);
                $fixedCount++;
            }

            // Si le chemin a été modifié, sauvegarder
            if ($coverImage !== $originalPath) {
                $music->cover_image = $coverImage;
                $music->save();
                $this->line("Corrigé: {$originalPath} -> {$coverImage}");
            }
        }

        $this->info("Correction terminée. {$fixedCount} chemins d'images corrigés.");
    }
}
