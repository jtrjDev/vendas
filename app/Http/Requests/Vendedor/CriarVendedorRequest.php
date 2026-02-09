<?php

namespace App\Http\Requests\Vendedor;

use Illuminate\Foundation\Http\FormRequest;

class CriarVendedorRequest extends FormRequest
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
            'nome' => ['required', 'string'],
            'email'=> ['required', 'email'],
            'cpf'  => ['required', 'max:11'],
            'observacoes' => ['required', 'string'],
            'comissao' => ['required', 'numeric'],
            'endereco' => ['required', 'array'],
            'endereco.cep'  => ['required', 'string', 'max:8'],
            'endereco.numero' => ['required', 'string'],
            'endereco.complemento' => ['required', 'string'],
            'endereco.bairro' => ['required', 'string'],
            'endereco.cidade' => ['required', 'string'],
            'endereco.estado' => ['required', 'string', 'max:2'],

        ];
    }


    public function messages()
    {
        return [
            'required'  => ':attribute e obrigatorio',
            'string'    => ':atrribute deve ser uma string',
            'email'     => ':atrribute deve ser um email',
            'max'       => ':attribute deve ter no maximo :max caracteres',
            'numeric'   => ':attribute deve ser um numero',
            'array'     => ':attribute de ser um array',
        ];
    }
}
