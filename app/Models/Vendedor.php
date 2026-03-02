<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends BaseModel
{
    protected $table = 'tb_vendedor';

    protected $primaryKey = 'id_vendedor';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id_vendedor',
        'comissao',
        'cpf',
        'observacoes',
        'id_endereco',
        'id_admin',
        'removido'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_vendedor');
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'id_endereco');
    }

    public function vendas()
    {
        return $this->hasMany(Venda::class, 'id_vendedor');
    }
}
