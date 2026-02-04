<?php

namespace App\Http\Controllers\Produtos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProdutoController extends Controller
{
    public function index(){
        return Inertia::render("produtos/Listar");
    }
}
