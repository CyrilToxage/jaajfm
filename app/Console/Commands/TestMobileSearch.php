<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use App\Models\Music;
use App\Models\Playlist;
use App\Models\User;

class TestMobileSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:mobile-search {query?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester la page de recherche mobile';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $query = $this->argument('query') ?? 'test';

        $this->info("=== TEST DE LA RECHERCHE MOBILE ===");
        $this->line("Query: {$query}");

        // 1. Vérifier la route
        $this->info("\n1. Vérification de la route /search");
        try {
            $route = Route::getRoutes()->getByName('search');
            if ($route) {
                $this->info("✅ Route /search trouvée");
                $this->line("Méthode: " . implode('|', $route->methods()));
                $this->line("URI: " . $route->uri());
            } else {
                $this->error("❌ Route /search non trouvée");
            }
        } catch (\Exception $e) {
            $this->error("❌ Erreur: " . $e->getMessage());
        }

        // 2. Vérifier les données de test
        $this->info("\n2. Vérification des données de test");

        $musicCount = Music::count();
        $playlistCount = Playlist::count();
        $userCount = User::count();

        $this->line("Musiques: {$musicCount}");
        $this->line("Playlists: {$playlistCount}");
        $this->line("Utilisateurs: {$userCount}");

        if ($musicCount === 0 && $playlistCount === 0 && $userCount === 0) {
            $this->warn("⚠️ Aucune donnée trouvée. La recherche pourrait ne pas fonctionner.");
        }

        // 3. Tester la recherche
        $this->info("\n3. Test de la recherche");

        $musics = Music::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        $playlists = Playlist::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        $users = User::where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        $this->line("Résultats trouvés:");
        $this->line("- Musiques: " . $musics->count());
        $this->line("- Playlists: " . $playlists->count());
        $this->line("- Utilisateurs: " . $users->count());

        // 4. Vérifier les composants
        $this->info("\n4. Vérification des composants");

        $components = [
            'resources/js/Pages/Search.vue',
            'resources/js/Components/MobileHeader.vue',
            'resources/js/Components/MobilePageHeader.vue'
        ];

        foreach ($components as $component) {
            if (file_exists($component)) {
                $this->info("✅ {$component}");
            } else {
                $this->error("❌ {$component} manquant");
            }
        }

        // 5. Recommandations
        $this->info("\n5. Recommandations");

        if ($musicCount === 0) {
            $this->line("💡 Exécutez: php artisan db:seed --class=MusicSeeder");
        }

        if ($playlistCount === 0) {
            $this->line("💡 Exécutez: php artisan db:seed --class=PlaylistSeeder");
        }

        if ($userCount === 0) {
            $this->line("💡 Exécutez: php artisan db:seed --class=UserSeeder");
        }

        $this->line("💡 Testez manuellement: http://localhost/search?q={$query}");

        return 0;
    }
}
