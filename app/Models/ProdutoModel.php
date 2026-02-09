<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'tb_produto';

    protected $fillable = [
        'nome',
        'valor',
        'id_admin',
        'removido'
    ];

    public function itens()
    {
        return $this->hasMany(Item::class, 'id_produto');
    }
}
