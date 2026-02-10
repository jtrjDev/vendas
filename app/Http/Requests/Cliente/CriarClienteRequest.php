<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class CriarClienteRequest extends FormRequest
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
        return [
           'nome'                   => ['required', 'string'],
           'email'                  => ['required', 'email'],
           'endereco'               => ['required', 'array'],
           'endereco.cep'           => ['required', 'string', 'max:8'],
           'endereco.rua'           => ['required', 'string', 'max:100'],
           'endereco.numero'        => ['required', 'string', 'max:10'],
           'endereco.complemento'   => ['required', 'string', 'max:50'],
           'endereco.bairro'        => ['required', 'string'],
           'endereco.cidade'        => ['required', 'string'],
           'endereco.estado'        => ['required', 'string', 'max:2'],
        ];
    }

    public  function messages()
    {
        return [
            'required'   => ':attribute e obrigatorio',
            'string'     => ':attribute deve ser uma string',
            'email'      => ':attribute deve ser um email',
            'max'        => ':attribute deve ter no maximo :max caracteres',
            'numeric'    => ':attribute deve ser um numero',
            'array'      => ':attribute deve ser um array',
        ];

    }
}
