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
        return Inertia::render("clientes/Listar");
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
                'cep'           => $request->endereco->cep,
                'rua'           => $request->endereco->rua,
                'numero'        => $request->endereco->numero,
                'complemento'   => $request->endereco->complemento,
                'bairro'        => $request->endereco->bairro,
                'cidade'        => $request->endereco->cidade,
                'estado'        => $request->endereco->estado,
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
