<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHorarioRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'locacionid' => 'required|integer|exists:Locaciones,Id',
            'diasemana' => 'required|integer|between:0,6',
            'hora' => 'required|date_format:H:i',
            'activo' => 'required|boolean',
            'notas' => 'nullable|string',
        ];
    }
}
