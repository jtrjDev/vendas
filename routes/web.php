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
    Route::get('/persistir/{id?}', [VendedorController::class, 'persistir'])->name('vendedores.persistir');


    //Rotas de persistencias
    Route::post('/create', [VendedorController::class, 'create'])->name('vendedores.create');
    Route::put('/update/{idVendedor}', [VendedorController::class, 'update'])->name('vendedores.update');
    Route::delete('/delete/{idVendedor}', [VendedorController::class, 'remove'])->name('vendedores.remove');

});

Route::prefix("/clientes")->group(function(){
    Route::get('/', [ClienteController::class, 'index'])->name('clientes.listar');
    Route::get('/persistir/{id?}', [ClienteController::class, 'persistir'])->name('clientes.persistir');

    //Persitencias do cliente
    Route::post('/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::put('/update/{idCliente}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/delete/{idCliente}', [ClienteController::class, 'remove'])->name('clientes.remove');
});
Route::prefix("/vendas")->group(function(){
    Route::get('/', [VendaController::class, 'index'])->name('vendas.listar');
    Route::get('/persistir', [VendaController::class, 'persistir'])->name('vendas.persistir');
});

Route::prefix("/produtos")->group(function(){
    Route::get('/', [ProdutoController::class, 'index'])->name('produtos.listar');
    Route::get('/persistir', [ProdutoController::class, 'persistir'])->name('produtos.persistir');
    //Persistencias
    Route::post('/create', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::put('/produtos/{id}', [ProdutoController::class, 'update'])
    ->name('produtos.update');

});


require __DIR__.'/settings.php';
