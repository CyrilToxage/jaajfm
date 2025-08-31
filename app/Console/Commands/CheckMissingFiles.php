<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Music;
use App\Models\Playlist;

class CheckMissingFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:missing-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifier les fichiers d\'images manquants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== VÉRIFICATION DES FICHIERS MANQUANTS ===');

        // 1. Vérifier les musiques
        $this->info('\n1. Vérification des images de musiques...');
        $musics = Music::whereNotNull('cover_image')->get();
        $missingMusicFiles = 0;
        $existingMusicFiles = 0;

        foreach ($musics as $music) {
            $filePath = public_path(str_replace('/storage/', 'storage/', $music->cover_image_url));

            if (file_exists($filePath)) {
                $existingMusicFiles++;
                $this->info("✅ {$music->title}: {$music->cover_image}");
            } else {
                $missingMusicFiles++;
                $this->error("❌ {$music->title}: {$music->cover_image}");
                $this->line("   Fichier attendu: {$filePath}");

                // Essayer de trouver le fichier dans storage/app/public
                $storagePath = storage_path('app/public/' . $music->cover_image);
                if (file_exists($storagePath)) {
                    $this->warn("   📁 Fichier trouvé dans storage: {$storagePath}");
                } else {
                    $this->warn("   🔍 Fichier introuvable");
                }
            }
        }

        // 2. Vérifier les playlists
        $this->info('\n2. Vérification des images de playlists...');
        $playlists = Playlist::whereNotNull('cover_image')->get();
        $missingPlaylistFiles = 0;
        $existingPlaylistFiles = 0;

        foreach ($playlists as $playlist) {
            $filePath = public_path(str_replace('/storage/', 'storage/', $playlist->cover_image_url));

            if (file_exists($filePath)) {
                $existingPlaylistFiles++;
                $this->info("✅ {$playlist->name}: {$playlist->cover_image}");
            } else {
                $missingPlaylistFiles++;
                $this->error("❌ {$playlist->name}: {$playlist->cover_image}");
                $this->line("   Fichier attendu: {$filePath}");

                // Essayer de trouver le fichier dans storage/app/public
                $storagePath = storage_path('app/public/' . $playlist->cover_image);
                if (file_exists($storagePath)) {
                    $this->warn("   📁 Fichier trouvé dans storage: {$storagePath}");
                } else {
                    $this->warn("   🔍 Fichier introuvable");
                }
            }
        }

        // 3. Résumé
        $this->info('\n=== RÉSUMÉ ===');
        $this->info("Musiques:");
        $this->line("  - Fichiers existants: {$existingMusicFiles}");
        $this->line("  - Fichiers manquants: {$missingMusicFiles}");

        $this->info("Playlists:");
        $this->line("  - Fichiers existants: {$existingPlaylistFiles}");
        $this->line("  - Fichiers manquants: {$missingPlaylistFiles}");

        if ($missingMusicFiles > 0 || $missingPlaylistFiles > 0) {
            $this->warn('\n⚠️  Solutions possibles:');
            $this->line('1. Vérifiez que les fichiers ont été uploadés correctement');
            $this->line('2. Vérifiez les permissions des dossiers');
            $this->line('3. Recréez le lien symbolique: php artisan storage:link');
            $this->line('4. Si les fichiers sont dans storage/app/public, copiez-les vers public/storage');
        } else {
            $this->info('\n🎉 Tous les fichiers sont présents !');
        }

        return 0;
    }
}
