<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FerramentaController;
use App\Http\Controllers\RepresentanteController;
use App\Http\Controllers\UsuarioController;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;



//----------Login------------//

Route::middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('login');
});

//----------Logout------------//
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');



Route::middleware('auth')->group(function () {

    //----------Home------------//
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //---------Clientes---------
    Route::prefix('clientes')->group(function () {
        Route::get('/', [ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/novo', [ClienteController::class, 'create'])->name('clientes.create');
        Route::get('importar-xml', [ClienteController::class, 'importarXml'])->name('clientes.importar-xml');
        Route::get('/{id}/editar', [ClienteController::class, 'edit'])->name('clientes.editar');
    });

    //---------Representantes---------
    Route::prefix('representantes')->group(function () {
        Route::get('/', [RepresentanteController::class, 'index'])->name('representantes.index');
        Route::get('/novo', [RepresentanteController::class, 'create'])->name('representantes.create');
        Route::get('/{id}/editar', [RepresentanteController::class, 'edit'])->name('representantes.editar');
    });

    //---------Usuarios---------
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');

    //---------Ferramentas---------
    Route::prefix('ferramentas')->group(function () {
        Route::get('/romaneios', [FerramentaController::class, 'romaneios'])->name('ferramentas.romaneios');
        Route::get('/importa-estoque', [FerramentaController::class, 'importaestoque'])->name('ferramentas.importa-estoque');
    });


});
