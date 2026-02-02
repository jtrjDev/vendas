<?php

namespace App\Http\Controllers\Vendedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VendedorController extends Controller
{
    public function index(){
        return Inertia::render("vendedores/Listar");
    }
    
    public function persistir()
    {
        return Inertia::render("vendedores/Persistir");
    }
}
