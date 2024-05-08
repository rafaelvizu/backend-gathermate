<?php

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\V1\CategoriaDespesaController;
use App\Http\Controllers\V1\CategoriaEventoController;
use App\Http\Controllers\V1\DespesaController;
use App\Http\Controllers\V1\EventoController;
use App\Http\Controllers\V1\InscricaoController;
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

    Route::prefix('eventos')->group(function () {
        Route::get('/', [EventoController::class, 'index'])
            ->name('v1.eventos.index');

        Route::get('/{evento}', [EventoController::class, 'show'])
            ->name('v1.eventos.show');

        Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
            Route::post('/', [EventoController::class, 'store'])
                ->name('v1.eventos.store');

            Route::put('/{evento}', [EventoController::class, 'update'])
                ->name('v1.eventos.update');

            Route::delete('/{evento}', [EventoController::class, 'destroy'])
                ->name('v1.eventos.destroy');
        });
    });

    Route::prefix('inscricoes')->group(function () {
        Route::post('/', [InscricaoController::class, 'store'])
            ->name('v1.inscricoes.store');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/', [InscricaoController::class, 'index'])
              ->name('v1.inscricoes.index');

            Route::get('/{inscricao}', [InscricaoController::class, 'show'])
              ->name('v1.inscricoes.show');
        });
    });


    Route::middleware(['auth:sanctum'])->prefix('categorias-despesa')->group(function () {
        Route::get('/', [CategoriaDespesaController::class, 'index'])
            ->name('v1.categorias-despesa.index');

        Route::post('/', [CategoriaDespesaController::class, 'store'])
            ->name('v1.categorias-despesa.store');

        Route::put('/{categoriaDespesa}', [CategoriaDespesaController::class, 'update'])
            ->name('v1.categorias-despesa.update');
    });

    Route::prefix('categoria-eventos')->group(function () {
        Route::get('/', [CategoriaEventoController::class, 'index'])
            ->name('v1.categoria-eventos.index');

        Route::get('/{categoriaEvento}', [CategoriaEventoController::class, 'show'])
            ->name('v1.categoria-eventos.show');

        Route::middleware(['auth:sanctum', 'can:admin'])->group(function () {
            Route::post('/', [CategoriaEventoController::class, 'store'])
                ->name('v1.categoria-eventos.store');

            Route::put('/{categoriaEvento}', [CategoriaEventoController::class, 'update'])
                ->name('v1.categoria-eventos.update');

        });


    });

    Route::middleware('auth:sanctum')->prefix('despesas')->group(function () {
        Route::get('/', [DespesaController::class, 'index'])
            ->name('v1.despesas.index');

        Route::get('/{despesa}', [DespesaController::class, 'show'])
            ->name('v1.despesas.show');

        Route::post('/', [DespesaController::class, 'store'])
            ->name('v1.despesas.store');

        Route::put('/{despesa}', [DespesaController::class, 'update'])
            ->name('v1.despesas.update');

        Route::delete('/{despesa}', [DespesaController::class, 'destroy'])
            ->name('v1.despesas.destroy');

    });

});


Route::fallback(function () {
    return response()->json(['message' => 'Not Found!'], 404);
})->name('api.fallback.404');


