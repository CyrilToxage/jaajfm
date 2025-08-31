<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Report;
use App\Models\Music;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class TestReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester le système de signalements';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== TEST DU SYSTÈME DE SIGNALEMENTS ===');

        // 1. Vérifier que la table existe
        $this->info('\n1. Vérification de la table reports...');
        if (!Schema::hasTable('reports')) {
            $this->error('❌ Table reports inexistante');
            $this->info('Exécutez: php artisan migrate');
            return 1;
        }
        $this->info('✅ Table reports existe');

        // 2. Vérifier les colonnes
        $this->info('\n2. Vérification des colonnes...');
        $columns = Schema::getColumnListing('reports');
        $requiredColumns = ['id', 'reporter_id', 'reportable_type', 'reportable_id', 'reason', 'status'];

        foreach ($requiredColumns as $column) {
            if (in_array($column, $columns)) {
                $this->info("✅ Colonne {$column} existe");
            } else {
                $this->error("❌ Colonne {$column} manquante");
            }
        }

        // 3. Vérifier les données existantes
        $this->info('\n3. Vérification des données...');
        $reportsCount = Report::count();
        $this->info("Nombre de signalements: {$reportsCount}");

        if ($reportsCount > 0) {
            $recentReports = Report::with(['reporter', 'reportable'])->latest()->take(3)->get();
            foreach ($recentReports as $report) {
                $this->line("Signalement #{$report->id}: {$report->reason} - {$report->status}");
                $this->line("  Signalé par: " . ($report->reporter ? $report->reporter->name : 'Utilisateur supprimé'));
                $this->line("  Élément: {$report->reportable_type} #{$report->reportable_id}");
            }
        }

        // 4. Vérifier les modèles référencés
        $this->info('\n4. Vérification des modèles référencés...');
        $reportableTypes = Report::distinct()->pluck('reportable_type')->toArray();

        foreach ($reportableTypes as $type) {
            if (class_exists($type)) {
                $this->info("✅ Modèle {$type} existe");
            } else {
                $this->error("❌ Modèle {$type} inexistant");
            }
        }

        // 5. Test de création d'un signalement
        $this->info('\n5. Test de création d\'un signalement...');

        $music = Music::first();
        $user = User::first();

        if (!$music || !$user) {
            $this->error('❌ Impossible de tester: pas de musique ou utilisateur disponible');
            return 1;
        }

        try {
            $report = Report::create([
                'reporter_id' => $user->id,
                'reportable_type' => 'App\Models\Music',
                'reportable_id' => $music->id,
                'reason' => 'test_reason',
                'description' => 'Test de signalement',
                'status' => 'pending'
            ]);

            $this->info("✅ Signalement de test créé avec succès (ID: {$report->id})");

            // Nettoyer le test
            $report->delete();
            $this->info("✅ Signalement de test supprimé");

        } catch (\Exception $e) {
            $this->error("❌ Erreur lors de la création du signalement: " . $e->getMessage());
            return 1;
        }

        // 6. Vérifier les routes
        $this->info('\n6. Vérification des routes...');
        $routes = [
            'POST /reports' => 'reports.store',
            'GET /reports' => 'reports',
            'POST /reports/{report}/resolve' => 'reports.resolve'
        ];

        foreach ($routes as $route => $name) {
            if (route($name, [], false)) {
                $this->info("✅ Route {$route} existe");
            } else {
                $this->warn("⚠️ Route {$route} non trouvée");
            }
        }

        $this->info('\n=== TEST TERMINÉ ===');
        $this->info('Si tous les tests sont passés, le système de signalements devrait fonctionner.');

        return 0;
    }
}
