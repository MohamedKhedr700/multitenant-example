<?php

declare(strict_types=1);

use App\Http\Controllers\UserController;
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

Route::prefix('v1/dashboard/users')
    ->middleware(['tenant_api'])
    ->group(function () {
        // store user
        Route::post('/', [UserController::class, 'store']);
        // list users
        Route::get('/', [UserController::class, 'index']);
        // show user
        Route::get('/{user}', [UserController::class, 'show']);
        // update user
        Route::put('/{user}', [UserController::class, 'update']);
        // delete user
        Route::delete('/{user}', [UserController::class, 'delete']);
    });
