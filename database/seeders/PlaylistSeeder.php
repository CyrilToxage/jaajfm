<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Playlist;
use App\Models\Music;
use Illuminate\Database\Seeder;

class PlaylistSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $musics = Music::all();

        // Créer des playlists pour chaque utilisateur
        $playlists = [
            [
                'name' => 'Mes Favoris',
                'description' => 'Ma playlist personnelle',
                'user_id' => 1,
                'musics' => [1, 3, 5]
            ],
            [
                'name' => 'Jazz & Blues',
                'description' => 'Collection jazz et blues',
                'user_id' => 2,
                'musics' => [3, 7, 9]
            ],
            [
                'name' => 'Rock Classics',
                'description' => 'Les meilleurs du rock',
                'user_id' => 3,
                'musics' => [6, 8, 10]
            ],
            [
                'name' => 'Pop Hits',
                'description' => 'Les hits pop du moment',
                'user_id' => 4,
                'musics' => [1, 2, 10]
            ],
            [
                'name' => 'Ambient Vibes',
                'description' => 'Musique ambiante relaxante',
                'user_id' => 5,
                'musics' => [5, 7, 9]
            ],
        ];

        foreach ($playlists as $playlistData) {
            $playlist = Playlist::create([
                'name' => $playlistData['name'],
                'description' => $playlistData['description'],
                'user_id' => $playlistData['user_id'],
                'is_public' => true,
            ]);

            // Ajouter les musiques à la playlist
            foreach ($playlistData['musics'] as $index => $musicId) {
                if ($music = $musics->find($musicId)) {
                    $playlist->musics()->attach($music->id, [
                        'order' => $index + 1
                    ]);
                }
            }
        }
    }
}
