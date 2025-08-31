<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Music;
use App\Models\Playlist;

class DiagnoseImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnose:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnostiquer les problèmes d\'images des musiques et playlists';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== DIAGNOSTIC DES IMAGES ===');

        $this->info('\n=== MUSICS ===');
        $musics = Music::whereNotNull('cover_image')->take(5)->get(['id', 'title', 'cover_image']);
        $this->info('Musics trouvées: ' . $musics->count());

        foreach ($musics as $music) {
            $this->line($music->id . ': ' . $music->title . ' -> ' . $music->cover_image . ' (URL: ' . $music->cover_image_url . ')');
        }

        $this->info('\n=== PLAYLISTS ===');
        $playlists = Playlist::whereNotNull('cover_image')->take(5)->get(['id', 'name', 'cover_image']);
        $this->info('Playlists trouvées: ' . $playlists->count());

        foreach ($playlists as $playlist) {
            $this->line($playlist->id . ': ' . $playlist->name . ' -> ' . $playlist->cover_image . ' (URL: ' . $playlist->cover_image_url . ')');
        }

        $this->info('\n=== VÉRIFICATION DES FICHIERS ===');

        // Vérifier quelques fichiers d'images
        $musicImages = Music::whereNotNull('cover_image')->take(3)->pluck('cover_image_url');
        foreach ($musicImages as $imageUrl) {
            $filePath = public_path(str_replace('/storage/', 'storage/', $imageUrl));
            $status = file_exists($filePath) ? 'EXISTS' : 'MISSING';
            $this->line("Music image: $imageUrl -> $status");
        }

        $playlistImages = Playlist::whereNotNull('cover_image')->take(3)->pluck('cover_image_url');
        foreach ($playlistImages as $imageUrl) {
            $filePath = public_path(str_replace('/storage/', 'storage/', $imageUrl));
            $status = file_exists($filePath) ? 'EXISTS' : 'MISSING';
            $this->line("Playlist image: $imageUrl -> $status");
        }

        return 0;
    }
}
