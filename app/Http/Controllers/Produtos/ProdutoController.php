<?php

namespace App\Http\Controllers\Produtos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Produto\CriarProdutoRequest;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProdutoController extends Controller
{
    /**
     * Lista os produtos
     */
    public function index()
    {
        $produtos = Produto::orderBy('id', 'desc')->get();

        return Inertia::render('produtos/Listar', [
            'produtos' => $produtos,
        ]);
    }

    /**
     * Abre a tela de cadastro (se futuramente precisar)
     */
    public function persistir()
    {
        return Inertia::render('produtos/Persistir');
    }

    /**
     * Persiste o produto no banco
     */
    public function create(CriarProdutoRequest $request)
{
    \Log::info('ENTROU NO CREATE', $request->all());

    DB::transaction(function () use ($request) {
        Produto::create([
            'nome'     => $request->nome,
            'valor'    => $request->valor,
            'id_admin' => auth()->id() ?? 1,
            'removido' => false,
        ]);
    });

    // ⬅️ SEM redirect
    return back();
}

public function update(CriarProdutoRequest $request, $id)
{
    \Log::info('ENTROU NO UPDATE', [
        'id' => $id,
        'dados' => $request->all(),
    ]);

    DB::transaction(function () use ($request, $id) {
        $produto = Produto::findOrFail($id);

        $produto->update([
            'nome'  => $request->nome,
            'valor' => $request->valor,
        ]);
    });

    return back();
}

}
