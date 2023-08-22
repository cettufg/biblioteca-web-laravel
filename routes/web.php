<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => '/'
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Rotas instituições
    Route::group([
        'prefix' => '/instituicao'
    ], function () {
        Route::get('/', [InstituicaoController::class, 'index'])->name('instituicao.index');
        Route::post('/', [InstituicaoController::class, 'store'])->name('instituicao.store');
        Route::patch('/{id}', [InstituicaoController::class, 'update'])->name('instituicao.update');
        Route::delete('/{id}', [InstituicaoController::class, 'destroy'])->name('instituicao.destroy');
    });

    //Rotas pesquisadores
    Route::group([
        'prefix' => '/pesquisador'
    ], function () {
        Route::get('/', [PesquisadorController::class, 'index'])->name('pesquisador.index');
        Route::post('/', [PesquisadorController::class, 'store'])->name('pesquisador.store');
        Route::patch('/{id}', [PesquisadorController::class, 'update'])->name('pesquisador.update');
        Route::delete('/{id}', [PesquisadorController::class, 'destroy'])->name('pesquisador.destroy');
    });

    //Rotas obras
    Route::group([
        'prefix' => '/obra'
    ], function () {
        Route::get('/', [ObraController::class, 'index'])->name('obra.index');
        Route::post('/', [ObraController::class, 'store'])->name('obra.store');
        Route::post('/{id}', [ObraController::class, 'update'])->name('obra.update');
        Route::delete('/{id}', [ObraController::class, 'destroy'])->name('obra.destroy');

        Route::post('/remove-thumb/{id}', [ObraController::class, 'removeThumb'])->name('obra.remove.thumb');
        Route::post('/remove-arquivo/{id}', [ObraController::class, 'removeArquivo'])->name('obra.remove.arquivo');
    });
});

require __DIR__.'/auth.php';
