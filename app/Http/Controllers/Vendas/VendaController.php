<?php

namespace App\Http\Controllers\Vendas;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Venda;
use App\Models\Vendedor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use League\Uri\Builder;

class VendaController extends Controller
{
    public function index(){

        $vendedores = Vendedor::quer()->with('user')->where('removido', false)->get();
        $clientes = Cliente::query()->where('removido', false)->get();

        $vendas = Venda::query()->with(['cliente', 'vendedor', 'items'])
                        ->where('removido', false)
                        ->when(auth()->user()->parent_user_id, function ($query){
                            $query->where('id_vendedor', auth()->user()->id);
                        })
                        ->get();
        return Inertia::render("vendas/Listar",
            [
                'vendas' => $vendas,
                'vendedores'=> $vendedores,
                'clientes'  => $clientes,
        ]);
    }
    public function persistir() :Response {
        return Inertia::render("vendas/Persistir");
    }
   
    
}
