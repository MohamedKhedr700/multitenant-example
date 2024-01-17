<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapDomainRoutes();
            $this->mapApiRoutes();
            $this->mapWebRoutes();
            $this->mapTenantApiRoutes();
        });
    }

    private function mapDomainRoutes(): void
    {
        $domains = glob(app_path('Domain/*'));

        foreach ($domains as $domainPath) {
            $domainRoutes = $this->getDomainRoutes($domainPath);
            $domainApiRoutes = $this->getDomainApiRoutes($domainPath);

            $this->discover($domainRoutes);

            $this->discoverApi($domainApiRoutes);

        }
    }

    /**
     * Get domain api routes.
     */
    private function getDomainRoutes(string $domainPath): array
    {
        return [
            $domainPath.'/routes/web.php',
            $domainPath.'/routes/tenant.php',
        ];
    }

    /**
     * Get domain api routes.
     */
    private function getDomainApiRoutes(string $domainPath): array
    {
        return [
            $domainPath.'/routes/api.php',
            $domainPath.'/routes/tenant-api.php',
        ];
    }

    /**
     * Discover path routes.
     */
    private function discover(array $routes, string $prefix = '/'): void
    {
        foreach ($routes as $path) {
            if (file_exists($path)) {
                Route::prefix($prefix)->group($path);
            }
        }
    }

    /**
     * Discover path routes.
     */
    private function discoverApi(array $routes): void
    {
        $this->discover($routes, 'api');
    }

    /**
     * Configure rate limiting.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    /**
     * Map web routes.
     */
    protected function mapWebRoutes(): void
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware('web')
                ->domain($domain)
                ->group(base_path('routes/web.php'));
        }
    }

    /**
     * Map api routes.
     */
    protected function mapApiRoutes(): void
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware('api')
                ->prefix('api')
                ->domain($domain)
                ->group(base_path('routes/api.php'));
        }
    }

    /**
     * Map tenant api routes.
     */
    protected function mapTenantApiRoutes(): void
    {
        if (file_exists(base_path('routes/tenant-api.php'))) {
            Route::prefix('api')
                ->group(base_path('routes/tenant-api.php'));
        }
    }

    /**
     * Gent tenancy central domains.
     */
    protected function centralDomains(): array
    {
        return config('tenancy.central_domains');
    }
}
