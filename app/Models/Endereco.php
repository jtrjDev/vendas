<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'tb_endereco';

    protected $fillable = [
        'cep',
        'rua',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'removido'
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'id_endereco');
    }

    public function vendedores()
    {
        return $this->hasMany(Vendedor::class, 'id_endereco');
    }
}
