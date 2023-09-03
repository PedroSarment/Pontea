<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivitiesRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255', // O título é obrigatório, uma string com no máximo 255 caracteres.
            'description' => 'required|string', // A descrição é obrigatória e deve ser uma string.
            'age_group_id' => 'required|integer|exists:age_groups,id', // age_group_id é obrigatório, um número inteiro e deve existir na tabela age_groups.
            'area_id' => 'required|integer|exists:areas,id', // area_id é obrigatório, um número inteiro e deve existir na tabela areas.
            'level_id' => 'required|integer|exists:levels,id', // level_id é obrigatório, um número inteiro e deve existir na tabela levels.
            'has_multimedia_resources' => 'required|boolean', // has_multimedia_resources é obrigatório e deve ser um valor booleano (true ou false).
            'has_visual_instructions' => 'required|boolean', // has_visual_instructions é obrigatório e deve ser um valor booleano (true ou false).
            'media_path_1' => 'string',
            'media_path_2' => 'string',
            'media_path_3' => 'string',
            'media_path_4' => 'string',
            'price' => 'required|numeric'
        ];
    }
}
