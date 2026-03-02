<?php

namespace App\Exports;

use App\Models\Venda;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class VendaExport implements FromCollection
{

    public function __construct(mixed $idVenda)
    {
        $this->idVenda = $idVenda;
    }

    public function collection()
    {
        $vendas = [
            [
                'Cliente',
                'Vendedor',
                'Data da Venda',
                'Comissao do Vendedor',
                'Valor Comissao',
                'Total da Venda',
                'Itens da Venda',
            ],
        ];

        $venda = Venda::with(['itens.produto', 'cliente', 'vendedor'])
                           ->where('id', $this->idVenda)
                           ->first();

        if (!$venda) {
            return Collection::make($vendas);
        }

        $totalItens = $venda->itens->sum(function ($item): float {
            return $item->quantidade * $item->valor;
        });

        $comissaoPercent = $venda->vendedor?->comissao ?? 0;
        $valorComissao   = ($totalItens * $comissaoPercent) / 100;

        $itensString = $venda->itens->map(function ($item): string {
            return $item->produto->nome . ' (Qtd: ' . $item->quantidade . ', Preço Unit: ' . $item->valor . ')';
        })->implode('; ');

        $vendas[] = [
            $venda->cliente->nome,
            $venda->user->name,
            $venda->data,
            $comissaoPercent . '%',
            $valorComissao,
            $totalItens,
            $itensString,
        ];

        return Collection::make($vendas);
    }
}