<?php

namespace App\Http\Controllers\Vendas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class VendaController extends Controller
{
    public function index(){
        return Inertia::render("vendas/Listar");
    }
    public function persistir() :Response {
        return Inertia::render("vendas/Persistir");
    }
   
    
}
