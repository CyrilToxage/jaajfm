<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\MusicComment;
use App\Models\User;
use App\Models\Music;
use Illuminate\Database\Seeder;

class InteractionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $musics = Music::all();

        // Créer des likes de différents utilisateurs
        foreach ($musics->take(8) as $index => $music) {
            $user = $users[$index % $users->count()];
            Like::create([
                'user_id' => $user->id,
                'music_id' => $music->id,
            ]);
        }

        // Créer des commentaires de différents utilisateurs
        $comments = [
            'Super chanson ! 🎵',
            'J\'adore cette mélodie',
            'Très bien produit !',
            'Parfait pour se détendre',
            'Excellent travail !',
            'Génial ! 👏',
            'Très créatif !',
            'J\'écoute en boucle !',
        ];

        foreach ($musics->take(6) as $index => $music) {
            $user = $users[$index % $users->count()];
            MusicComment::create([
                'content' => $comments[$index] ?? 'Belle musique !',
                'user_id' => $user->id,
                'music_id' => $music->id,
            ]);
        }
    }
}
