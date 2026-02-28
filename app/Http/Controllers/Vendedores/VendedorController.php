<?php

namespace App\Http\Controllers\Vendedores;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendedor\CriarVendedorRequest;
use App\Http\Requests\Vendedor\EditarVendedorRequest;
use App\Models\Endereco;
use App\Models\User;
use App\Models\Vendedor;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VendedorController extends Controller
{
    public function index()
    {

        $vendedores = Vendedor::query()->with('user')->where('removido', false)->get();
        return Inertia::render("vendedores/Listar", [
            'vendedores'    => $vendedores
        ]);
    }

    public function persistir($idVendedor = null)
    {
        if ($idVendedor !== null) {
            $vendedor = Vendedor::with(['user', 'endereco'])
                ->where('id_vendedor', $idVendedor)
                ->first();
        }

        return Inertia::render("vendedores/Persistir", [
            'vendedor' => $vendedor ?? null,
            'idVendedor' => $idVendedor,
        ]);
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

            $user->addRole('vendedor');
            
            $endereco = Endereco::query()->create([
                'cep'           => $request->cep,
                'rua'           => $request->rua,
                'numero'        => $request->numero,
                'complemento'   => $request->complemento,
                'bairro'        => $request->bairro,
                'cidade'        => $request->cidade,
                'estado'        => $request->estado,
            ]);

            $vendedor = Vendedor::query()->create([
                'id_vendedor'   => $user->id,
                'comissao'      => $request->comissao,
                'cpf'           => $request->cpf,
                'id_endereco'   => $endereco->id,
                'id_admin'      => auth()->user()->id,
            ]);
            $conn->commit();
            // Após o sucesso, retorna uma resposta com redirecionamento
            return redirect()
                ->route('vendedores.listar')
                ->with('success', 'Vendedor cadastrado com sucesso');
        } catch (\Exception $e) {
            $conn->rollback();
        }
    }

    public function update(EditarVendedorRequest $request)
    {
        $conn = \DB::connection();
        try {
            $conn->beginTransaction();
            $vendedor = Vendedor::query()->where('id_vendedor', $request->id_vendedor)->first();

            $vendedor->user->update([
                'name' => $request->nome,
                'email' => $request->email,
            ]);

            $vendedor->endereco->update([
                'cep'           => $request->cep,
                'rua'           => $request->rua,
                'numero'        => $request->numero,
                'complemento'   => $request->complemento,
                'bairro'        => $request->bairro,
                'cidade'        => $request->cidade,
                'estado'        => $request->estado,
            ]);

            $vendedor->update([
                'comissao'      => $request->comissao,
                'cpf'           => $request->cpf,
                'observacoes'   => $request->observacoes,
            ]);

            $conn->commit();
            // Após o sucesso, retorna uma resposta com redirecionamento
            return redirect()
                ->route('vendedores.listar')
                ->with('success', 'Vendedor editado com sucesso'); // Certifique-se de que a rota esteja configurada corretamente
        } catch (\Exception $e) {
            $conn->rollback();
            dd($e);
        }
    }

    public function remove(mixed $idVendedor)
    {
        $vendedor = Vendedor::query()->where('id_vendedor', $idVendedor)->first();

        $vendedor->update([
            'removido' => true,

        ]);

        // Após o sucesso, retorna uma resposta com redirecionamento
        return redirect()
            ->route('vendedores.listar')
            ->with('success', 'Vendedor removido com sucesso');  // Certifique-se de que a rota esteja configurada corretamente

    }
}
