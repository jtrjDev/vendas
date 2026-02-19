<?php

namespace App\Http\Requests\Vendedor;

use App\Http\Requests\Endereco\CriarEnderecoRequest;
use Illuminate\Foundation\Http\FormRequest;

class EditarVendedorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        
        $vendedor = [
            'id_vendedor'   => ['required', 'integer', 'exists:tb_vendedor,id_vendedor'],
            'nome'          => ['required', 'string'],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $this->route('idVendedor') . ',id'
            ],
            'cpf'           => ['required', 'min:11','max:11'],
            'observacoes'   => ['nullable', 'string'],
            'comissao'      => ['required', 'numeric'],
            

        ];
        $endereco = (new CriarEnderecoRequest())->rules();
        return array_merge($vendedor,$endereco);
    }


    public function messages()
    {
        $vendedor = [
            'required'  => ':attribute e obrigatorio',
            'integer'   => ':attribute deve ser um numero inteiro',
            'exists'    => ':attribute não existe',
            'string'    => ':atrribute deve ser uma string',
            'email'     => ':atrribute deve ser um email',
            'min'       => ':attribute deve ter no minimo :min caracteres',
            'max'       => ':attribute deve ter no maximo :max caracteres',
            'numeric'   => ':attribute deve ser um numero',
            'array'     => ':attribute de ser um array',
        ];
        $endereco = (new CriarEnderecoRequest())->messages();
        return array_merge($vendedor,$endereco);
    }
}
