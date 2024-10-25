<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class ConfirmarEventoRequest extends FormRequest
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
                'precio' => 'nullable|number',
            ];
    }

    public function messages()
    {
        return [
            '*.number' => 'El campo :attribute debe ser numerico',
        ];
    }
}
