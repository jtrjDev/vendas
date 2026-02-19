<?php

namespace App\Http\Requests\Endereco;

use Illuminate\Foundation\Http\FormRequest;

class CriarEnderecoRequest extends FormRequest
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
            'cep'           => ['required', 'string', 'max:8'],
            'rua'           => ['required', 'string'],
            'numero'        => ['required', 'string'],
            'complemento'   => ['nullable', 'string'],
            'bairro'        => ['required', 'string'],
            'cidade'        => ['required', 'string'],
            'estado'        => ['required', 'string', 'max:2'],
            ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'string'   => 'O campo :attribute precisa ser uma string',
            'max'      => 'O campo :attribute não pode ter mais que :max caracteres',
        ];
    }
}
