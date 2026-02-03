<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSinalRequest extends FormRequest
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
            'palavra_portugues' => 'required|string|max:255',
            'definicao' => 'required|string',
            'parametros' => 'required|string',
            'contexto_utilizacao' => 'required|string',
            'status' => 'required|in:catalogado,em_validacao,publicado',
            'video' => 'file|mimes:mp4,avi,mov,wmv|max:10240',
            'imagens' => 'array',
            'imagens.*' => 'file|mimes:jpg,jpeg,png,gif,webp,svg|max:5120',
            'categorias' => 'required|array',
            'categorias.*' => 'exists:categorias,id',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'O campo :attribute deve ser uma string.',
            'max' => 'O campo :attribute não pode exceder :max caracteres.',
            'in' => 'O campo :attribute deve ser um dos seguintes valores: :values.',
            'file' => 'O campo :attribute deve ser um arquivo válido.',
            'mimes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
            'array' => 'O campo :attribute deve ser um array.',
            'exists' => 'O valor selecionado para :attribute é inválido.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'palavra_portugues' => 'palavra em português',
            'definicao' => 'definição',
            'parametros' => 'parâmetros',
            'contexto_utilizacao' => 'contexto de utilização',
            'status' => 'status',
            'video' => 'vídeo',
            'imagens' => 'imagens',
            'categorias' => 'categorias',
        ];
    }
}
