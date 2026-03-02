<?php

namespace App\Http\Controllers\Vendas;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Venda\CriarVendaRequest;
use App\Http\Requests\Venda\EditarVendaRequest;
use App\Models\Cliente;
use App\Models\Item;
use App\Models\Produto;
use App\Models\Venda;
use App\Models\Vendedor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VendaController extends Controller
{
    public function index()
    {

        $vendedores = Vendedor::query()->with('user')->where('removido', false)->get();

        $clientes = Cliente::query()->where('removido', false)->get();

        $vendas = Venda::query()->with(['cliente', 'vendedor', 'itens'])->where('removido', false)->get();

        return Inertia::render('vendas/Listar',
            [
                'vendas'     => $vendas,
                'vendedores' => $vendedores,
                'clientes'   => $clientes,
            ]);

    }

    public function persistir($idVenda = null)
    {
        $produtos = Produto::query()->where('removido', false)->get();
        $clientes = Cliente::query()->where('removido', false)->get();

        $venda = Venda::query()->with(['itens.produto'])->where('id', $idVenda)->first();
        return Inertia::render('vendas/Persistir',
            [
                'clientes' => $clientes,
                'produtos' => $produtos,
                'venda'    => $venda ?? null,
            ]);
    }

    public function create(CriarVendaRequest $request)
    {
        $conn = \DB::connection();

        try {
            $conn->beginTransaction();
            $idAdmin = auth()->user()->parent_user_id ?? auth()->user()->id;
            $venda   = Venda::query()->create([
                'data'        => $request->data_venda,
                'id_cliente'  => $request->id_cliente,
                'id_vendedor' => auth()->user()->id,
                'id_admin'    => $idAdmin,
            ]);

            foreach ($request->itens as $item) {
                Item::query()->create([
                    'id_venda'   => $venda->id,
                    'id_produto' => $item['id_produto'],
                    'valor'      => $item['valor'],
                    'id_admin'   => $idAdmin,

                ]);
            }

            $conn->commit();
            return redirect()->route('vendas.listar');

        } catch (\Exception $e) {
            $conn->rollBack();
            dd($e);
        }
    }

    public function update(EditarVendaRequest $request, mixed $idVenda)
    {
        $conn = \DB::connection();
        try {
            $conn->beginTransaction();

            $venda = Venda::query()->where('id', $idVenda)->first();

            $venda->update([
                'data'       => $request->data_venda,
                'id_cliente' => $request->id_cliente,
            ]);

            foreach ($request->itens as $item) {
                if (!empty($item['id'])) {
                    $itemVez = Item::query()->where('id', $item['id'])->first();
                    $itemVez->update([
                        'id_produto' => $item['id_produto'],
                        'valor'      => $item['valor'],

                    ]);
                } else {
                    Item::query()->create([
                        'id_venda'   => $idVenda,
                        'id_produto' => $item['id_produto'],
                        'valor'      => $item['valor'],
                        'id_admin'   => auth()->user()->parent_user_id ?? auth()->user()->id,

                    ]);
                }
            }

            $conn->commit();
            return redirect()->route('vendas.listar');

        } catch (\Exception $e) {
            $conn->rollBack();
            dd($e);
        }
    }

    public function remove($idVenda)
    {
        $venda = Venda::query()->where('id', $idVenda)->first();
        $venda->update([
            'removido' => true,
        ]);

    }

    public function removerItem($idItem)
    {
        $item    = item::query()->where('id', $idItem)->first();
        $idVenda = $item->id_venda;
        $item->delete();
        return redirect()->route('vendas.persistir', $idVenda);
    }
}
