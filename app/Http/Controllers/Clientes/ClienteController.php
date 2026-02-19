<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\CriarClienteRequest;
use App\Models\Cliente;
use App\Models\Endereco;
use Inertia\Inertia;


class ClienteController extends Controller
{
    public function index(){
        $clientes = Cliente::query()->where('removido', false)->get();
        return Inertia::render("clientes/Listar", [
            'clientes' => $clientes
        ]);
    }

    public function persistir(){
        return Inertia::render("clientes/Persistir");
    }

    public function create(CriarClienteRequest $request)
    {
        
        $conn = \DB::connection();

        try {
            $conn->beginTransaction();
            //Criar o endereco
            $endereco = Endereco::query()->create([
                'cep'           => $request->cep,
                'rua'           => $request->rua,
                'numero'        => $request->numero,
                'complemento'   => $request->complemento,
                'bairro'        => $request->bairro,
                'cidade'        => $request->cidade,
                'estado'        => $request->estado,
            ]);
            // Criar o cliente
            $cliente = Cliente::query()->create([
                'nome'          => $request->nome,
                'email'         => $request->email,
                'id_endereco'   => $endereco->id,
                'id_admin'      => auth()->user()->id,
            ]);

            $conn->commit();

        } catch (\Exception $e) {
            $conn->rollback();
        }

    }
}
