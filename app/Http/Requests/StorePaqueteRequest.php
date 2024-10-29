<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaqueteRequest extends FormRequest
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
            'nombre' => 'required|string',
            'precio' => 'required|numeric',
            'descripcion' => 'required|string',
            //            'activo'        =>'nullable', //true,false
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del servicio es requerido.',
            'precio.required' => 'El precio del servicio es requerido.',
            'descripcion.required' => 'La descripcion del servicio es requerida.',

            'nombre.string' => 'El nombre del servicio debe ser una cadena de texto.',
            'precio.numeric' => 'El precio del servicio debe ser una numerico.',
            'descripcion.string' => 'La descripcion del servicio debe ser una cadena de texto.',
        ];
    }
}
