<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'tb_cliente';

    protected $fillable = [
        'nome',
        'email',
        'id_endereco',
        'id_admin',
        'removido'
    ];

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'id_endereco');
    }

    public function vendas()
    {
        return $this->hasMany(Venda::class, 'id_cliente');
    }
}
