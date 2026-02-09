<?php

namespace App\Http\Controllers\Vendedores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendedor\CriarVendedorRequest;
use App\Models\Endereco;
use App\Models\User;
use App\Models\Vendedor;
use Illuminate\Container\Attributes\DB;
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

    public function create(CriarVendedorRequest $request)
    {
        $conn = \DB::connection();
        try {
            $conn->beginTransaction();
            $emailAnteArroba = explode('@', $request->email)[0];

        $user = User::create([
            'name' => $request->nome,
            'parent_user_id' => auth()->user()->id,
            'email' => $request->email,
            'password'  => password_hash($emailAnteArroba, PASSWORD_DEFAULT),

        ]);

        $endereco = Endereco::query()->create([
            'cep'           => $request->endereco->cep,
            'rua'           => $request->endereco->rua,
            'numero'        => $request->endereco->numero,
            'complemento'   => $request->endereco->complemento,
            'bairro'        => $request->endereco->bairro,
            'cidade'        => $request->endereco->cidade,
            'estado'        => $request->endereco->estado,
        ]);

        $vendedor = Vendedor::query()->create([
            'id_vendedor'   => $user->id,
            'comissao'      => $request->comissao,
            'cpf'           => $request->cpf,
            'observacoes'   => $request->observacao,
            'id_endereco'   => $endereco->id,
            'id_admin'      => auth()->user()->id,
        ]); 
        $conn->commit();
        } catch (\Exception $e) {
            $conn->rollback();
        }
       
    }
}
