<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
//Controllers abaixo
use App\Http\Controllers\Vendedores\VendedorController;
use App\Http\Controllers\Clientes\ClienteController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix("/vendedores")->group(function(){
    Route::get('/',[VendedorController::class, 'index'])->name('vendedores.listar');
    Route::get('/persistir', [VendedorController::class, 'persistir'])->name('vendedores.persistir');

});

Route::prefix("/clientes")->group(function(){
    Route::get('/', [ClienteController::class, 'index'])->name('clientes.listar');
    Route::get('/persistir', [ClienteController::class, 'persistir'])->name('clientes.persistir');
});


require __DIR__.'/settings.php';
