<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ClienteController extends Controller
{
    public function index(){
        return Inertia::render("clientes/Listar");
    }

    public function persistir(){
        return Inertia::render("clientes/Persistir");
    }
}
