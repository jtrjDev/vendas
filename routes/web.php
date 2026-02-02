<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
//Controllers abaixo
use App\Http\Controllers\Vendedores\VendedorController;

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


require __DIR__.'/settings.php';
