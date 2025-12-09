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
            'palavra_portugues' => 'required|string|max:255,' .$this->sinais->id,
            'definicao' => 'nullable|string,' .$this->sinais->id,
            'instrucao_execucao' => 'nullable|string,' .$this->sinais->id,
            'status' => 'required|in:Sinal Existente Catalogado, Em Validacao, Publicado,' .$this->sinais->id,
            'video_principal_id' => 'nullable|exists:videos,id,' .$this->sinais->id,
        ];
    }
}
