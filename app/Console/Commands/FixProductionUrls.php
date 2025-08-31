<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Music;
use App\Models\Playlist;
use App\Models\User;

class FixProductionUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:production-urls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifier et corriger les URLs pour la production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== VÉRIFICATION DES URLS DE PRODUCTION ===');

        // 1. Vérifier la configuration
        $this->info('\n1. Configuration...');
        $this->line("APP_URL: " . config('app.url'));
        $this->line("APP_ENV: " . config('app.env'));
        $this->line("FILESYSTEM_DISK: " . config('filesystems.default'));

        // 2. Vérifier le lien symbolique
        $this->info('\n2. Vérification du lien symbolique...');
        $storageLink = public_path('storage');
        if (is_link($storageLink)) {
            $this->info('✅ Lien symbolique existe');
            $this->line("Lien pointe vers: " . readlink($storageLink));
        } else {
            $this->warn('❌ Lien symbolique manquant');
            $this->info('Création du lien symbolique...');
            $this->call('storage:link');
        }

        // 3. Tester quelques URLs d'images
        $this->info('\n3. Test des URLs d\'images...');

        // Test musiques
        $music = Music::whereNotNull('cover_image')->first();
        if ($music) {
            $this->line("Musique test: {$music->title}");
            $this->line("URL générée: {$music->cover_image_url}");

            // Vérifier si l'URL est accessible
            $testUrl = config('app.url') . $music->cover_image_url;
            $this->line("URL complète: {$testUrl}");

            // Test simple d'existence du fichier
            $filePath = public_path(str_replace('/storage/', 'storage/', $music->cover_image_url));
            if (file_exists($filePath)) {
                $this->info("✅ Fichier existe localement");
            } else {
                $this->error("❌ Fichier manquant localement");
            }
        }

        // Test playlists
        $playlist = Playlist::whereNotNull('cover_image')->first();
        if ($playlist) {
            $this->line("Playlist test: {$playlist->name}");
            $this->line("URL générée: {$playlist->cover_image_url}");

            // Vérifier si l'URL est accessible
            $testUrl = config('app.url') . $playlist->cover_image_url;
            $this->line("URL complète: {$testUrl}");

            // Test simple d'existence du fichier
            $filePath = public_path(str_replace('/storage/', 'storage/', $playlist->cover_image_url));
            if (file_exists($filePath)) {
                $this->info("✅ Fichier existe localement");
            } else {
                $this->error("❌ Fichier manquant localement");
            }
        }

        // 4. Vérifier les permissions
        $this->info('\n4. Vérification des permissions...');
        $storagePath = storage_path('app/public');
        $publicStoragePath = public_path('storage');

        if (is_readable($storagePath)) {
            $this->info("✅ Storage readable");
        } else {
            $this->error("❌ Storage non readable");
        }

        if (is_readable($publicStoragePath)) {
            $this->info("✅ Public storage readable");
        } else {
            $this->error("❌ Public storage non readable");
        }

        $this->info('\n=== DIAGNOSTIC TERMINÉ ===');
        $this->info('Si des fichiers sont manquants, exécutez: php artisan fix:image-paths');
        $this->info('Si le lien symbolique manque, exécutez: php artisan storage:link');

        return 0;
    }
}
