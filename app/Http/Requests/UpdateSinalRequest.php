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
            'palavra_portugues' => 'required|string|max:255' .$this->route('sinal')->id,
            'definicao' => 'nullable|string',
            'instrucao_execucao' => 'nullable|string',
            'status' => 'required|in:catalogado,em_validacao,publicado',
            'video' => 'file|mimes:mp4,avi,mov,wmv|max:10240',
            'categorias' => 'nullable|array',
            'categorias.*' => 'exists:categorias,id',
        ];
    }
}
