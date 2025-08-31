<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur admin par défaut
        User::create([
            'name' => 'Admin JaaJ FM',
            'email' => 'admin@jaajfm.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Utilisateur admin créé avec succès !');
        $this->command->info('Email: admin@jaajfm.com');
        $this->command->info('Mot de passe: admin123');
    }
}
