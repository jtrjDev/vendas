<?php

namespace App\Http\Requests\Venda;

use Illuminate\Foundation\Http\FormRequest;

class EditarVendaRequest extends FormRequest
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
            'id'                 => ['required', 'integer', 'exists:tb_venda,id'],
            'data_venda'         => ['required', 'date'],
            'id_cliente'         => ['required', 'exists:tb_cliente,id'],
            'itens'              => ['required', 'array', 'min:1'],
            'itens.*.id_produto' => ['required', 'exists:tb_produto,id'],
            'itens.*.quantidade' => ['required', 'integer', 'min:1'],
            'itens.*.valor'      => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'date'     => 'O campo :attribute deve ser uma data válida.',
            'exists'   => 'O :attribute selecionado é inválido.',
            'array'    => 'O campo :attribute deve ser um array.',
            'min'      => 'O campo :attribute deve ter no mínimo :min.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'numeric'  => 'O campo :attribute deve ser um número válido.',

        ];
    }
}
