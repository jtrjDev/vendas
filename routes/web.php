<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
//Controllers abaixo
use App\Http\Controllers\Vendedores\VendedorController;
use App\Http\Controllers\Clientes\ClienteController;
use App\Http\Controllers\Vendas\VendaController;
use App\Http\Controllers\Produtos\ProdutoController;

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

    //Rotas de persistencias
    Route::post('/create', [VendedorController::class, 'create'])->name('vendedores.create');


});

Route::prefix("/clientes")->group(function(){
    Route::get('/', [ClienteController::class, 'index'])->name('clientes.listar');
    Route::get('/persistir', [ClienteController::class, 'persistir'])->name('clientes.persistir');

    //Persitencias do cliente
    Route::post('/create', [ClienteController::class, 'create'])->name('clientes.create');
});
Route::prefix("/vendas")->group(function(){
    Route::get('/', [VendaController::class, 'index'])->name('vendas.listar');
    Route::get('/persistir', [VendaController::class, 'persistir'])->name('vendas.persistir');
});

Route::prefix("/produtos")->group(function(){
    Route::get('/', [ProdutoController::class, 'index'])->name('produtos.listar');
});


require __DIR__.'/settings.php';
