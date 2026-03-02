<?php

namespace App\Http\Controllers\Vendas;

use App\Exports\VendaExport;
use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Venda;
use App\Models\Vendedor;
use App\Models\Vendas;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use League\Uri\Builder;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class VendaController extends Controller
{
    public function index()
    {

        $vendedores = Vendedor::query()->with('user')->where('removido', false)->get();
        $clientes = Cliente::query()->where('removido', false)->get();

        $vendas = Venda::query()->with(['cliente', 'vendedor', 'items'])
            ->where('removido', false)
            ->when(auth()->user()->parent_user_id, function ($query) {
                $query->where('id_vendedor', auth()->user()->id);
            })
            ->get();
        return Inertia::render(
            "vendas/Listar",
            [
                'vendas' => $vendas,
                'vendedores' => $vendedores,
                'clientes'  => $clientes,
            ]
        );
    }
    public function persistir(): Response
    {
        $clientes = Cliente::where('removido', false)->get();
        $vendedores = Vendedor::with('user')
            ->where('removido', false)
            ->get();

        $produtos = Produto::where('removido', false)->get();

        return Inertia::render('vendas/Persistir', [
            'clientes' => $clientes,
            'vendedores' => $vendedores,
            'produtos' => $produtos,
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:tb_cliente,id',
            'id_vendedor' => 'required|exists:users,id',
            'itens' => 'required|array|min:1',
            'itens.*.id_produto' => 'required|exists:tb_produto,id',
            'itens.*.valor' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {

            // Criar venda
            $venda = Venda::create([
                'data' => now(),
                'id_cliente' => $request->id_cliente,
                'id_vendedor' => $request->id_vendedor,
                'id_admin' => Auth::id(),
                'removido' => false,
            ]);

            // Criar itens
            foreach ($request->itens as $item) {
                Item::create([
                    'id_venda' => $venda->id,
                    'id_produto' => $item['id_produto'],
                    'valor' => $item['valor'],
                    'id_admin' => Auth::id(),
                    'removido' => false,
                ]);
            }

            DB::commit();

            return redirect()->route('vendas.index')
                ->with('success', 'Venda cadastrada com sucesso!');
        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->withErrors([
                'erro' => 'Erro ao cadastrar venda.'
            ]);
        }
    }

    public function export($idVenda)
    {
        try {
            return Excel::donwload(new VendaExport($idVenda), 'vendas.xlsx');
        } catch (\Throwable $e) {
            dd($e);
        }
    }
}
