<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFotoRequest extends FormRequest
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
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'descripcion.required' => 'La descripcion es requerida.',
            'descripcion.string' => 'La descripcion debe ser una cadena de texto.',
            'foto.image' => 'El archivo subido debe ser una imagen.',
            'foto.mimes' => 'Solo se permiten archivos JPEG, PNG, JPG, WEBP y AVIF.',
            'foto.max' => 'El tamaño máximo permitido para el avatar es de 2MB.',
        ];
    }
}
