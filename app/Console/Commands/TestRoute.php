<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class TestRoute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:route {route}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tester une route spécifique';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $routeName = $this->argument('route');

        $this->info("=== TEST DE LA ROUTE: {$routeName} ===");

        try {
            $route = Route::getRoutes()->getByName($routeName);

            if ($route) {
                $this->info("✅ Route trouvée");
                $this->line("Méthode: " . implode('|', $route->methods()));
                $this->line("URI: " . $route->uri());
                $this->line("Action: " . $route->getActionName());
                $this->line("Middleware: " . implode(', ', $route->middleware()));
            } else {
                $this->error("❌ Route non trouvée");

                // Lister les routes disponibles
                $this->info("\nRoutes disponibles contenant 'reports':");
                $routes = Route::getRoutes();
                foreach ($routes as $route) {
                    if (str_contains($route->getName(), 'reports')) {
                        $this->line("- {$route->getName()}: " . implode('|', $route->methods()) . " " . $route->uri());
                    }
                }
            }
        } catch (\Exception $e) {
            $this->error("❌ Erreur: " . $e->getMessage());
        }

        return 0;
    }
}
