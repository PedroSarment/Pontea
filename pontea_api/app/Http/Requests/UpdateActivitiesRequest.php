<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivitiesRequest extends FormRequest
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
            'title' => 'string|max:255', // O título deve ser uma string com no máximo 255 caracteres.
            'description' => 'string', // A descrição deve ser uma string.
            'age_group_id' => 'integer|exists:age_groups,id', // age_group_id deve ser um número inteiro e existir na tabela age_groups.
            'area_id' => 'integer|exists:areas,id', // area_id deve ser um número inteiro e existir na tabela areas.
            'level_id' => 'integer|exists:levels,id', // level_id deve ser um número inteiro e existir na tabela levels.
            'has_multimedia_resources' => 'boolean', // has_multimedia_resources deve ser um valor booleano (true ou false).
            'has_visual_instructions' => 'boolean', // has_visual_instructions deve ser um valor booleano (true ou false).
            'media_path_1' => 'string',
            'media_path_2' => 'string',
            'media_path_3' => 'string',
            'media_path_4' => 'string',
            'price' => 'numeric'
        ];
    }
}
