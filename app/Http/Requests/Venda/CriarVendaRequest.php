<?php

namespace App\Http\Requests\Venda;

use Illuminate\Foundation\Http\FormRequest;

class CriarVendaRequest extends FormRequest
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
            'data'                  => ['required', 'date'],
            'id_cliente'            => ['required', 'exists:tb_cliente,id'],
            'itens'                 => ['required', 'array', 'min:1'],
            'itens.*.id_produto'    => ['required', 'exists:tb_produto,id'],
            'itens.*.quantidade'    => ['required', 'integer', 'min:1'],
            'itens.*.valor'         => ['required', 'integer', 'min:1'],
            
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatorio',
            'date'  => 'O campo :attribute deve ser uma data válida',
            'exists'    => 'o :attribute selecionado é invalido',
            'array' => 'o campo :attribute deve ser um array',
            'min'   => 'o campo :attribute deve ter no minimo :min',
            'integer' => 'o campo :attribute deve ter um numero inteiro',
            'numeric' => 'o campo :attribute deve ser um nuemro valido',
        ];
    }
}
