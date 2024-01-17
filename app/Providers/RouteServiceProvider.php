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
            $this->mapApiRoutes();
            $this->mapWebRoutes();
            $this->mapTenantApiRoutes();
        });
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
