<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Music;

class AddSlugsToExistingMusicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $musics = Music::whereNull('slug')->orWhere('slug', '')->get();

        foreach ($musics as $music) {
            $music->slug = Music::generateSlug($music->title);
            $music->save();
        }

        $this->command->info('Slugs ajoutés à ' . $musics->count() . ' musiques.');
    }
}
