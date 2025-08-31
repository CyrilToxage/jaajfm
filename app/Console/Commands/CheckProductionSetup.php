<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CheckProductionSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:production-setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifier la configuration de production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== VÉRIFICATION DE LA CONFIGURATION DE PRODUCTION ===');

        // 1. Vérifier la clé d'application
        $this->info('\n1. Vérification de la clé d\'application...');
        $appKey = config('app.key');
        if (empty($appKey) || $appKey === 'base64:') {
            $this->error('❌ Clé d\'application manquante ou invalide');
            $this->info('Exécutez: php artisan key:generate');
        } else {
            $this->info('✅ Clé d\'application configurée');
        }

        // 2. Vérifier l'environnement
        $this->info('\n2. Vérification de l\'environnement...');
        $this->line("APP_ENV: " . config('app.env'));
        $this->line("APP_DEBUG: " . (config('app.debug') ? 'true' : 'false'));

        if (config('app.debug')) {
            $this->warn('⚠️  Mode debug activé en production');
        }

        // 3. Vérifier la base de données
        $this->info('\n3. Vérification de la base de données...');
        try {
            \DB::connection()->getPdo();
            $this->info('✅ Connexion à la base de données OK');
        } catch (\Exception $e) {
            $this->error('❌ Erreur de connexion à la base de données: ' . $e->getMessage());
        }

        // 4. Vérifier les migrations
        $this->info('\n4. Vérification des migrations...');
        try {
            $pendingMigrations = Artisan::call('migrate:status');
            $this->info('✅ Statut des migrations vérifié');
        } catch (\Exception $e) {
            $this->error('❌ Erreur lors de la vérification des migrations: ' . $e->getMessage());
        }

        // 5. Vérifier les permissions des dossiers
        $this->info('\n5. Vérification des permissions...');
        $directories = [
            'storage' => storage_path(),
            'bootstrap/cache' => base_path('bootstrap/cache'),
            'public/storage' => public_path('storage')
        ];

        foreach ($directories as $name => $path) {
            if (is_writable($path)) {
                $this->info("✅ {$name} est accessible en écriture");
            } else {
                $this->error("❌ {$name} n'est pas accessible en écriture");
            }
        }

        // 6. Vérifier les routes
        $this->info('\n6. Vérification des routes critiques...');
        $criticalRoutes = [
            'reports.store' => 'POST /reports',
            'music.like' => 'POST /music/{id}/like',
            'music.comment.add' => 'POST /music/{id}/comments'
        ];

        foreach ($criticalRoutes as $name => $description) {
            if (route($name, [], false)) {
                $this->info("✅ Route {$description} existe");
            } else {
                $this->warn("⚠️ Route {$description} non trouvée");
            }
        }

        // 7. Vérifier les middlewares
        $this->info('\n7. Vérification des middlewares...');
        $middlewares = [
            'web' => \App\Http\Middleware\HandleInertiaRequests::class,
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class
        ];

        foreach ($middlewares as $name => $class) {
            if (class_exists($class)) {
                $this->info("✅ Middleware {$name} existe");
            } else {
                $this->error("❌ Middleware {$name} inexistant");
            }
        }

        $this->info('\n=== VÉRIFICATION TERMINÉE ===');

        return 0;
    }
}
