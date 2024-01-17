<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::prefix('v1')
    ->middleware(['tenant_api'])
    ->group(function () {
        Route::get('/', function () {

            foreach (User::all(['id', 'name']) as $user) {
                echo $user;
                echo '<br>';
                echo '<br>';
            }

            return 'The id of the current tenant is '.tenant('id');
        });
    });
