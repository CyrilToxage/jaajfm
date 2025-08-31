<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixEnvConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:env-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Corriger la configuration de l\'environnement';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== CORRECTION DE LA CONFIGURATION ===');

        // 1. Vérifier la configuration actuelle
        $this->info('\n1. Configuration actuelle...');
        $this->line("APP_URL: " . config('app.url'));
        $this->line("APP_ENV: " . config('app.env'));
        $this->line("FILESYSTEM_DISK: " . config('filesystems.default'));

        // 2. Afficher les recommandations
        $this->info('\n2. Recommandations...');
        
        if (!str_starts_with(config('app.url'), 'http')) {
            $this->warn('⚠️  APP_URL doit commencer par http:// ou https://');
            $this->line('Ajoutez dans votre .env:');
            $this->line('APP_URL=http://jaajfm.test');
        }

        if (config('filesystems.default') !== 'public') {
            $this->warn('⚠️  FILESYSTEM_DISK devrait être "public" pour les images');
            $this->line('Ajoutez dans votre .env:');
            $this->line('FILESYSTEM_DISK=public');
        }

        // 3. Corriger les chemins d'images dupliqués
        $this->info('\n3. Correction des chemins d\'images...');
        $this->call('fix:image-paths');

        // 4. Nettoyer le cache
        $this->info('\n4. Nettoyage du cache...');
        $this->call('config:clear');
        $this->call('cache:clear');

        $this->info('\n=== CORRECTION TERMINÉE ===');
        $this->info('N\'oubliez pas de mettre à jour votre fichier .env avec les bonnes valeurs !');

        return 0;
    }
}
