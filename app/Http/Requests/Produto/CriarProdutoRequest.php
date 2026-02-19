<?php

namespace App\Http\Requests\Produto;

use Illuminate\Foundation\Http\FormRequest;

class CriarProdutoRequest extends FormRequest
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
            'nome'  => ['required','string', 'max:150'],
            'valor' => ['required', 'numeric', 'min:0'],

        ];
    }

    public function messages()
    {
        return [
            'required'          => 'O campo :attribute e obrigatorio',
            'string'            => 'O campo :attribute deve ser uma string',
            'max'               => 'O campo :attribute não pode exceder :max caracteres.',
            'numeric'           => 'O campo :attribute deve ser um numero',
            'min'               => 'O campo :attribute deve ter no minimo :min',
            
        ];
    }
}