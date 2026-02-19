<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditarClienteRequest extends FormRequest
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
        $cliente = [
            'id_cliente'             => ['required', 'integer', 'exists:tb_cliente, id_cliente'],
            'nome'                   => ['required', 'string'],
            'email'                  => ['required', 'email'],
           
        ];
        $endereco = (new CriarEnderecoRequest())->rules();
        return array_merge($cliente, $endereco);
    }

    public  function messages()
    {
        $cliente = [
            'required'   => ':attribute e obrigatorio',
            'string'     => ':attribute deve ser uma string',
            'email'      => ':attribute deve ser um email',
            'max'        => ':attribute deve ter no maximo :max caracteres',
            'numeric'    => ':attribute deve ser um numero',
            'array'      => ':attribute deve ser um array',
        ];

        $endereco = (new CriarEnderecoRequest())->rules();
        return array_merge($cliente, $endereco);

    }
}
