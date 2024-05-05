<?php

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\V1\EventoController;
use App\Http\Controllers\V1\ManageUser;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {

        Route::post('login', [UserController::class, 'login'])
            ->middleware('guest:sanctum')
            ->name('v1.login');

        Route::post('logout', [UserController::class, 'logout'])
            ->middleware('auth:sanctum')
            ->name('v1.logout');

        Route::get('me', [UserController::class, 'me'])
                ->middleware('auth:sanctum')
            ->name('v1.me');


        Route::post('reset-password', [UserController::class, 'resetPassword'])
            ->middleware('auth:sanctum')
            ->name('v1.reset-password');

        Route::post('updateProfile', [UserController::class, 'updateProfile'])
            ->middleware('auth:sanctum')
            ->name('v1.updateProfile');
    });

    Route::middleware('auth:sanctum')->prefix('dict')->group(function () {
       Route::get('cidades', [CidadeController::class, 'index'])
           ->name('v1.cidades.index');
    });

    Route::middleware(['auth:sanctum', 'can:admin'])->prefix('manage')->group(function () {
        Route::get('users', [ManageUser::class, 'index'])
            ->name('v1.manage.users');

        Route::get('users/{user}', [ManageUser::class, 'show'])
            ->name('v1.manage.users.show');

        Route::post('users', [ManageUser::class, 'store'])
            ->name('v1.manage.users.store');

        Route::put('users/{user}', [ManageUser::class, 'update'])
            ->name('v1.manage.users.update');

        Route::post('users/{user}/new-temp-password', [ManageUser::class, 'newTempPassword'])
            ->name('v1.manage.users.new-temp-password');

    });

    Route::middleware(['auth:sanctum'])->prefix('eventos')->group(function () {
        Route::get('/', [EventoController::class, 'index'])
            ->name('v1.eventos.index');

        Route::get('/{evento}', [EventoController::class, 'show'])
            ->name('v1.eventos.show');

        Route::post('/', [EventoController::class, 'store'])
            ->name('v1.eventos.store');

        Route::put('/{evento}', [EventoController::class, 'update'])
            ->name('v1.eventos.update');

        Route::delete('/{evento}', [EventoController::class, 'destroy'])
            ->name('v1.eventos.destroy');
    });

});


Route::fallback(function () {
    return response()->json(['message' => 'Not Found!'], 404);
})->name('api.fallback.404');


