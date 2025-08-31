<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Database\Seeder;

class FollowSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        // Créer des abonnements entre utilisateurs
        $follows = [
            // Alex suit Sarah et Mike
            ['follower_id' => 1, 'following_id' => 2],
            ['follower_id' => 1, 'following_id' => 3],

            // Sarah suit Alex et Emma
            ['follower_id' => 2, 'following_id' => 1],
            ['follower_id' => 2, 'following_id' => 4],

            // Mike suit Alex et David
            ['follower_id' => 3, 'following_id' => 1],
            ['follower_id' => 3, 'following_id' => 5],

            // Emma suit Sarah et David
            ['follower_id' => 4, 'following_id' => 2],
            ['follower_id' => 4, 'following_id' => 5],

            // David suit Mike et Emma
            ['follower_id' => 5, 'following_id' => 3],
            ['follower_id' => 5, 'following_id' => 4],
        ];

        foreach ($follows as $follow) {
            UserFollow::create($follow);
        }
    }
}
