<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Music;
use App\Models\Playlist;

class AssignDefaultImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:default-images {--force : Forcer l\'assignation sans confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assigner des images par défaut aux éléments sans images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== ASSIGNATION D\'IMAGES PAR DÉFAUT ===');

        // 1. Identifier les éléments sans images
        $this->info('\n1. Identification des éléments sans images...');

        $musicsWithoutImages = Music::whereNull('cover_image')->get();
        $playlistsWithoutImages = Playlist::whereNull('cover_image')->get();

        $this->line("Musiques sans images: " . $musicsWithoutImages->count());
        $this->line("Playlists sans images: " . $playlistsWithoutImages->count());

        // 2. Vérifier les images disponibles
        $this->info('\n2. Vérification des images disponibles...');

        $availableMusicImages = $this->getAvailableImages('uploads/covers');
        $availablePlaylistImages = $this->getAvailableImages('playlist-covers');

        $this->line("Images de musique disponibles: " . count($availableMusicImages));
        $this->line("Images de playlist disponibles: " . count($availablePlaylistImages));

        if (count($availableMusicImages) === 0 && count($availablePlaylistImages) === 0) {
            $this->error('Aucune image disponible pour l\'assignation.');
            return 1;
        }

        // 3. Demander confirmation
        if (!$this->option('force')) {
            if (!$this->confirm('Voulez-vous assigner des images par défaut aux éléments sans images ?')) {
                $this->info('Opération annulée.');
                return 0;
            }
        }

        // 4. Assigner aux musiques
        $this->info('\n3. Assignation aux musiques...');
        $assignedMusics = 0;
        foreach ($musicsWithoutImages as $music) {
            if (count($availableMusicImages) > 0) {
                $randomImage = $availableMusicImages[array_rand($availableMusicImages)];
                $music->cover_image = $randomImage;
                $music->save();
                $assignedMusics++;
                $this->line("Assigné: {$music->title} -> {$randomImage}");
            }
        }

        // 5. Assigner aux playlists
        $this->info('\n4. Assignation aux playlists...');
        $assignedPlaylists = 0;
        foreach ($playlistsWithoutImages as $playlist) {
            if (count($availablePlaylistImages) > 0) {
                $randomImage = $availablePlaylistImages[array_rand($availablePlaylistImages)];
                $playlist->cover_image = $randomImage;
                $playlist->save();
                $assignedPlaylists++;
                $this->line("Assigné: {$playlist->name} -> {$randomImage}");
            }
        }

        // 6. Résumé final
        $this->info('\n=== ASSIGNATION TERMINÉE ===');
        $this->info("Musiques assignées: {$assignedMusics}");
        $this->info("Playlists assignées: {$assignedPlaylists}");

        return 0;
    }

    private function getAvailableImages($folder)
    {
        $path = public_path("storage/{$folder}");
        if (!is_dir($path)) {
            return [];
        }

        $files = glob($path . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        $images = [];

        foreach ($files as $file) {
            $images[] = $folder . '/' . basename($file);
        }

        return $images;
    }
}
