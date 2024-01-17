<?php

use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
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
