<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Music;
use App\Models\Playlist;

class CleanMissingImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:missing-images {--force : Forcer le nettoyage sans confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Nettoyer les références aux images manquantes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== NETTOYAGE DES IMAGES MANQUANTES ===');

        // 1. Identifier les fichiers manquants
        $this->info('\n1. Identification des fichiers manquants...');

        $missingMusics = [];
        $musics = Music::whereNotNull('cover_image')->get();

        foreach ($musics as $music) {
            $filePath = public_path(str_replace('/storage/', 'storage/', $music->cover_image_url));
            if (!file_exists($filePath)) {
                $missingMusics[] = $music;
            }
        }

        $missingPlaylists = [];
        $playlists = Playlist::whereNotNull('cover_image')->get();

        foreach ($playlists as $playlist) {
            $filePath = public_path(str_replace('/storage/', 'storage/', $playlist->cover_image_url));
            if (!file_exists($filePath)) {
                $missingPlaylists[] = $playlist;
            }
        }

        // 2. Afficher le résumé
        $this->info("\n2. Résumé des fichiers manquants:");
        $this->line("Musiques avec images manquantes: " . count($missingMusics));
        $this->line("Playlists avec images manquantes: " . count($missingPlaylists));

        if (count($missingMusics) > 0) {
            $this->info("\nMusiques affectées:");
            foreach ($missingMusics as $music) {
                $this->line("- {$music->title} (ID: {$music->id})");
            }
        }

        if (count($missingPlaylists) > 0) {
            $this->info("\nPlaylists affectées:");
            foreach ($missingPlaylists as $playlist) {
                $this->line("- {$playlist->name} (ID: {$playlist->id})");
            }
        }

        // 3. Demander confirmation
        if (!$this->option('force')) {
            if (!$this->confirm('Voulez-vous supprimer les références aux images manquantes ?')) {
                $this->info('Opération annulée.');
                return 0;
            }
        }

        // 4. Nettoyer les musiques
        $this->info('\n3. Nettoyage des musiques...');
        $cleanedMusics = 0;
        foreach ($missingMusics as $music) {
            $music->cover_image = null;
            $music->save();
            $cleanedMusics++;
            $this->line("Nettoyé: {$music->title}");
        }

        // 5. Nettoyer les playlists
        $this->info('\n4. Nettoyage des playlists...');
        $cleanedPlaylists = 0;
        foreach ($missingPlaylists as $playlist) {
            $playlist->cover_image = null;
            $playlist->save();
            $cleanedPlaylists++;
            $this->line("Nettoyé: {$playlist->name}");
        }

        // 6. Résumé final
        $this->info('\n=== NETTOYAGE TERMINÉ ===');
        $this->info("Musiques nettoyées: {$cleanedMusics}");
        $this->info("Playlists nettoyées: {$cleanedPlaylists}");
        $this->info("Les images manquantes ont été supprimées de la base de données.");
        $this->info("Les éléments utiliseront maintenant l'icône par défaut.");

        return 0;
    }
}
