<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'tb_item';

    protected $fillable = [
        'id_venda',
        'id_produto',
        'valor',
        'id_admin',
        'removido'
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class, 'id_venda');
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto');
    }
}
