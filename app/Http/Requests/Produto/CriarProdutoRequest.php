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
            'valor' => ['required', 'numeric'],

        ];
    }

    public function messages()
    {
        return [
            'required'  => ':attribute e obrigatorio',
            'decimal'   => ':attribute precisa ser valor',
        ];
    }
}