<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name' => 'required|string|unique:roles,name|min:3|max:50',
            'guard_name' => 'required|string',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'O :attribute é obrigatório.',
            'string' => 'O :attribute deve ser uma string.',
            'unique' => 'O :attribute já está em uso.',
            'array' => 'As :attribute devem ser um array.',
            'exists' => 'O valor selecionado para :attribute é inválido.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nome da função',
            'guard_name' => 'nome do guard',
            'permissions' => 'permissões',
        ];
    }
}
