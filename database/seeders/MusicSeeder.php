<?php

namespace Database\Seeders;

use App\Models\Music;
use App\Models\User;
use App\Models\MusicGenre;
use Illuminate\Database\Seeder;

class MusicSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $genres = MusicGenre::all();

        $musics = [
            [
                'title' => 'Dangerous Woman',
                'description' => 'Une chanson pop énergique avec des influences rock',
                'file_path' => '/music/dangerous-woman.mp3',
                'duration' => 180,
                'views' => 15400,
                'genre_names' => ['Pop'],
                'is_approved' => true,
            ],
            [
                'title' => 'Neon Dreams',
                'description' => 'Synthwave électronique avec des mélodies nostalgiques',
                'file_path' => '/music/neon-dreams.mp3',
                'duration' => 240,
                'views' => 8900,
                'genre_names' => ['Électronique'],
                'is_approved' => true,
            ],
            [
                'title' => 'Midnight Jazz',
                'description' => 'Jazz nocturne avec saxophone et piano',
                'file_path' => '/music/midnight-jazz.mp3',
                'duration' => 320,
                'views' => 6700,
                'genre_names' => ['Jazz'],
                'is_approved' => true,
            ],
            [
                'title' => 'Digital Love',
                'description' => 'Chanson électronique avec vocoder',
                'file_path' => '/music/digital-love.mp3',
                'duration' => 200,
                'views' => 12300,
                'genre_names' => ['Électronique'],
                'is_approved' => true,
            ],
            [
                'title' => 'Ocean Waves',
                'description' => 'Musique ambiante relaxante avec sons d\'océan',
                'file_path' => '/music/ocean-waves.mp3',
                'duration' => 480,
                'views' => 4500,
                'genre_names' => ['Ambient'],
                'is_approved' => true,
            ],
            [
                'title' => 'Rock Anthem',
                'description' => 'Rock classique avec guitares puissantes',
                'file_path' => '/music/rock-anthem.mp3',
                'duration' => 280,
                'views' => 9800,
                'genre_names' => ['Rock'],
                'is_approved' => true,
            ],
            [
                'title' => 'Classical Symphony',
                'description' => 'Symphonie classique orchestrale',
                'file_path' => '/music/classical-symphony.mp3',
                'duration' => 600,
                'views' => 3200,
                'genre_names' => ['Classique'],
                'is_approved' => true,
            ],
            [
                'title' => 'Hip Hop Beat',
                'description' => 'Beat hip-hop avec flow rap',
                'file_path' => '/music/hip-hop-beat.mp3',
                'duration' => 220,
                'views' => 7600,
                'genre_names' => ['Hip-Hop'],
                'is_approved' => true,
            ],
            [
                'title' => 'Folk Story',
                'description' => 'Chanson folk acoustique avec guitare',
                'file_path' => '/music/folk-story.mp3',
                'duration' => 260,
                'views' => 5400,
                'genre_names' => ['Folk'],
                'is_approved' => true,
            ],
            [
                'title' => 'Pop Sensation',
                'description' => 'Hit pop avec mélodie accrocheuse',
                'file_path' => '/music/pop-sensation.mp3',
                'duration' => 190,
                'views' => 11200,
                'genre_names' => ['Pop'],
                'is_approved' => true,
            ],
        ];

        // Liste des images de cover disponibles
        $availableCovers = [
            '1756254950_68ae52e642e80.jpg',
            '1756254579_68ae51731218c.jpg',
            '1756253663_68ae4ddf31fb7.jpg',
            '1756252894_68ae4adecd98f.jpg',
            '1756252131_68ae47e3787a4.jpg',
        ];

        foreach ($musics as $index => $music) {
            // Distribuer les musiques entre les différents utilisateurs
            $user = $users[$index % $users->count()];

            // Extraire les noms de genres
            $genreNames = $music['genre_names'];
            unset($music['genre_names']);

            // Assigner une cover aléatoire
            $music['cover_image'] = 'uploads/covers/' . $availableCovers[$index % count($availableCovers)];

            // Créer la musique
            $musicModel = Music::create(array_merge($music, ['user_id' => $user->id]));

            // Associer des genres aléatoires (entre 1 et 4 genres par musique)
            if ($genres->count() > 0) {
                $randomGenres = $genres->random(rand(1, min(4, $genres->count())));
                $musicModel->genres()->attach($randomGenres->pluck('id'));
            }
        }
    }
}
