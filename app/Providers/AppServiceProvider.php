<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Blade::directive('safeVite', function (string $expression): string {
            return "<?php try { echo app(\\Illuminate\\Foundation\\Vite::class)({$expression}); } catch (\\Throwable \$e) {} ?>";
        });
    }
}
