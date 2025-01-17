<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFotoRequest extends FormRequest
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
            'descripcion' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'descripcion.required' => 'La descripcion es requerida.',
            'descripcion.string' => 'La descripcion debe ser una cadena de texto.',
        ];
    }
}
