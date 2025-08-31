<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Music;
use App\Models\Playlist;
use Illuminate\Support\Facades\Storage;

class FixProductionImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:production-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnostiquer et corriger les problèmes d\'images en production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== DIAGNOSTIC DES IMAGES EN PRODUCTION ===');

        // 1. Vérifier le lien symbolique
        $this->info('\n1. Vérification du lien symbolique...');
        $storageLink = public_path('storage');
        if (is_link($storageLink)) {
            $this->info('✅ Lien symbolique existe');
        } else {
            $this->warn('❌ Lien symbolique manquant');
            $this->info('Création du lien symbolique...');
            $this->call('storage:link');
        }

        // 2. Vérifier les musiques
        $this->info('\n2. Vérification des images de musiques...');
        $musics = Music::whereNotNull('cover_image')->get();
        $this->info("Musiques avec images: {$musics->count()}");

        foreach ($musics as $music) {
            $this->line("ID {$music->id}: {$music->title}");
            $this->line("  - Chemin DB: {$music->cover_image}");
            $this->line("  - URL générée: {$music->cover_image_url}");
            
            // Vérifier si le fichier existe
            $filePath = str_replace('/storage/', 'storage/', $music->cover_image_url);
            $fullPath = public_path($filePath);
            
            if (file_exists($fullPath)) {
                $this->info("  ✅ Fichier existe: {$fullPath}");
            } else {
                $this->error("  ❌ Fichier manquant: {$fullPath}");
                
                // Essayer de trouver le fichier dans storage/app/public
                $storagePath = storage_path('app/public/' . str_replace('uploads/covers/', '', $music->cover_image));
                if (file_exists($storagePath)) {
                    $this->info("  📁 Fichier trouvé dans storage: {$storagePath}");
                }
            }
        }

        // 3. Vérifier les playlists
        $this->info('\n3. Vérification des images de playlists...');
        $playlists = Playlist::whereNotNull('cover_image')->get();
        $this->info("Playlists avec images: {$playlists->count()}");

        foreach ($playlists as $playlist) {
            $this->line("ID {$playlist->id}: {$playlist->name}");
            $this->line("  - Chemin DB: {$playlist->cover_image}");
            $this->line("  - URL générée: {$playlist->cover_image_url}");
            
            // Vérifier si le fichier existe
            $filePath = str_replace('/storage/', 'storage/', $playlist->cover_image_url);
            $fullPath = public_path($filePath);
            
            if (file_exists($fullPath)) {
                $this->info("  ✅ Fichier existe: {$fullPath}");
            } else {
                $this->error("  ❌ Fichier manquant: {$fullPath}");
                
                // Essayer de trouver le fichier dans storage/app/public
                $storagePath = storage_path('app/public/' . str_replace('playlist-covers/', '', $playlist->cover_image));
                if (file_exists($storagePath)) {
                    $this->info("  📁 Fichier trouvé dans storage: {$storagePath}");
                }
            }
        }

        // 4. Vérifier la configuration
        $this->info('\n4. Configuration du stockage...');
        $this->line("FILESYSTEM_DISK: " . config('filesystems.default'));
        $this->line("APP_URL: " . config('app.url'));
        $this->line("Storage public URL: " . config('filesystems.disks.public.url'));

        return 0;
    }
}
