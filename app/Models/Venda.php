<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'tb_venda';

    protected $fillable = [
        'data',
        'id_cliente',
        'id_vendedor',
        'id_admin',
        'removido'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'id_vendedor');
    }

    public function itens()
    {
        return $this->hasMany(Item::class, 'id_venda');
    }
}
