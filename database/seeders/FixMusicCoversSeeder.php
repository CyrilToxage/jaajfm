<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Music;

class FixMusicCoversSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $musics = Music::whereNotNull('cover_image')->get();

        foreach ($musics as $music) {
            // Si le cover_image ne commence pas par storage/, l'ajouter
            if ($music->cover_image && !str_starts_with($music->cover_image, 'storage/')) {
                $music->cover_image = 'storage/' . $music->cover_image;
                $music->save();
            }
        }

        $this->command->info('Covers de musique corrigées pour ' . $musics->count() . ' musiques.');
    }
}
