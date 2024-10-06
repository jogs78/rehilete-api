<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServicioRequest extends FormRequest
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
            'nombre'        =>'required|string', 
            'precio'        =>'required|numeric',
            'descripcion'   =>'required|string',
            'minimo'        =>'required|numeric|integer|nullable',
        ];
    }
    public function messages(): array
    {
        return [
            'nombre.required'        =>'El nombre del servicio es requerido.',
            'precio.required'        =>'El precio del servicio es requerido.',
            'descripcion.required'   =>'La descripcion del servicio es requerida.',
            'minimo.required'        =>'El minimo del servicio es requerido.',

            'nombre.string'        =>'El nombre del servicio debe ser una cadena de texto.',
            'precio.numeric'       =>'El precio del servicio debe ser una numerico.',
            'descripcion.string'   =>'La descripcion del servicio debe ser una cadena de texto.',
            'minimo.numeric'       =>'El minimo del servicio debe ser una numerico.',

            'minimo.integer'        =>'El minimo del servicio debe ser un numero entero.',
            

        ];
    }

}
