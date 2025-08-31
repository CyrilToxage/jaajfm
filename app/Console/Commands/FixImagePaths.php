<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Music;
use App\Models\Playlist;

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
        $this->info('=== CORRECTION DES CHEMINS D\'IMAGES ===');

        // Corriger les musiques
        $this->info('\n1. Correction des chemins des musiques...');
        $musics = Music::whereNotNull('cover_image')->get();
        $fixedCount = 0;

        foreach ($musics as $music) {
            $originalPath = $music->cover_image;
            $newPath = $originalPath;

            // Nettoyer les chemins dupliqués
            if (str_contains($newPath, 'storage/uploads/covers/storage/uploads/covers/')) {
                $newPath = str_replace('storage/uploads/covers/storage/uploads/covers/', 'uploads/covers/', $newPath);
                $fixedCount++;
            } elseif (str_contains($newPath, 'uploads/covers/storage/uploads/covers/')) {
                $newPath = str_replace('uploads/covers/storage/uploads/covers/', 'uploads/covers/', $newPath);
                $fixedCount++;
            } elseif (str_contains($newPath, 'storage/uploads/covers/')) {
                $newPath = str_replace('storage/uploads/covers/', 'uploads/covers/', $newPath);
                $fixedCount++;
            }

            // S'assurer que le chemin commence par uploads/covers/
            if (!str_starts_with($newPath, 'uploads/covers/')) {
                $newPath = 'uploads/covers/' . basename($newPath);
                $fixedCount++;
            }

            if ($newPath !== $originalPath) {
                $music->cover_image = $newPath;
                $music->save();
                $this->line("Corrigé: {$originalPath} -> {$newPath}");
            }
        }

        // Corriger les playlists
        $this->info('\n2. Correction des chemins des playlists...');
        $playlists = Playlist::whereNotNull('cover_image')->get();
        $playlistFixedCount = 0;

        foreach ($playlists as $playlist) {
            $originalPath = $playlist->cover_image;
            $newPath = $originalPath;

            // Nettoyer les chemins dupliqués
            if (str_contains($newPath, 'storage/playlist-covers/storage/playlist-covers/')) {
                $newPath = str_replace('storage/playlist-covers/storage/playlist-covers/', 'playlist-covers/', $newPath);
                $playlistFixedCount++;
            } elseif (str_contains($newPath, 'playlist-covers/storage/playlist-covers/')) {
                $newPath = str_replace('playlist-covers/storage/playlist-covers/', 'playlist-covers/', $newPath);
                $playlistFixedCount++;
            } elseif (str_contains($newPath, 'storage/playlist-covers/')) {
                $newPath = str_replace('storage/playlist-covers/', 'playlist-covers/', $newPath);
                $playlistFixedCount++;
            }

            // S'assurer que le chemin commence par playlist-covers/
            if (!str_starts_with($newPath, 'playlist-covers/')) {
                $newPath = 'playlist-covers/' . basename($newPath);
                $playlistFixedCount++;
            }

            if ($newPath !== $originalPath) {
                $playlist->cover_image = $newPath;
                $playlist->save();
                $this->line("Corrigé: {$originalPath} -> {$newPath}");
            }
        }

        $this->info("\n✅ Correction terminée!");
        $this->info("Musiques corrigées: {$fixedCount}");
        $this->info("Playlists corrigées: {$playlistFixedCount}");

        return 0;
    }
}
