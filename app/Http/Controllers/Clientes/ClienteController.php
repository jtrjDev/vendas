<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\CriarClienteRequest;
use App\Http\Requests\Cliente\EditarClienteRequest;
use App\Models\Cliente;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
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

    public function persistir($idCliente = null){
        if ($idCliente !== null) {
            $cliente = Cliente::with(['endereco'])
                    ->where('id_cliente', $idCliente)
                    ->first();
        }
        return Inertia::render("clientes/Persistir", [
            'cliente' => $cliente ?? null,
            'idCliente'=> $idCliente,
        ]);
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
                'cpf'           => $request->cpf,
                'id_endereco'   => $endereco->id,
                'id_admin'      => auth()->user()->id,
            ]);

            $conn->commit();
            return redirect()
                    ->with('success', 'Cliente cadastrado com sucesso')
                    ->route('clientes.listar');


        } catch (\Exception $e) {
            $conn->rollback();
        }

    }

    public function update(EditarVendedorRequest $request)
    {
        $conn = \DB::connection();
        try {
             $conn->beginTransaction();
             $cliente = Cliente::query()->where('id_cliente', $request->id_cliente)->first();

              $cliente->endereco->update([
                'cep'           => $request->cep,
                'rua'           => $request->rua,
                'numero'        => $request->numero,
                'complemento'   => $request->complemento,
                'bairro'        => $request->bairro,
                'cidade'        => $request->cidade,
                'estado'        => $request->estado,
            ]);
            // Criar o cliente
            $cliente->update([
                'nome'          => $request->nome,
                'email'         => $request->email,
                'cpf'           => $request->cpf,
            ]);
            return redirect()
                ->route('clientes.listar')
                ->with('success', 'Cliente editado com sucesso');
        } catch (\Throwable $e) {
             $conn->rollback();
             dd($e);
        }
    }

    public function remove(mixed $idCliente)
    {
        $cliente = Cliente::query()->where('id_cliente', $idCliente)->first();

        $cliente->update([
            'removido' => true,
        ]);
        return redirect()
            ->route('vendedores.listar')
            ->with('success', 'Vendedor removido com sucesso');
    }
}
