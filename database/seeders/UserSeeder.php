<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des utilisateurs de test
        $users = [
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ],
            [
                'name' => 'Alex Music',
                'email' => 'alex@jaajfm.com',
            ],
            [
                'name' => 'Sarah Jazz',
                'email' => 'sarah@jaajfm.com',
            ],
            [
                'name' => 'Mike Rock',
                'email' => 'mike@jaajfm.com',
            ],
            [
                'name' => 'Emma Pop',
                'email' => 'emma@jaajfm.com',
            ],
            [
                'name' => 'David Ambient',
                'email' => 'david@jaajfm.com',
            ],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        }
    }
}
