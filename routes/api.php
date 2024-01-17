<?php

use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1/dashboard/tenants')
    ->group(function () {
        // store tenant
        Route::post('/', [TenantController::class, 'store']);
        // list tenants
        Route::get('/', [TenantController::class, 'index']);
        // show tenant
        Route::get('/{tenant}', [TenantController::class, 'show']);
        // update tenant
        Route::put('/{tenant}', [TenantController::class, 'update']);
        // delete tenant
        Route::delete('/{tenant}', [TenantController::class, 'delete']);
    });
