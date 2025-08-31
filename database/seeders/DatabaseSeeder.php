<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Les utilisateurs sont créés par UserSeeder

        // Seed les données de base
        $this->call([
            UserSeeder::class,
            AdminUserSeeder::class,
            MusicGenreSeeder::class,
            MusicSeeder::class,
            FixMusicCoversSeeder::class,
            InteractionSeeder::class,
            FollowSeeder::class,
            PlaylistSeeder::class,
            AddSlugsToExistingMusicSeeder::class,
        ]);
    }
}
