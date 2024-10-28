<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGastoRequest extends FormRequest
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
        //descripcion, cantidad
        return [
            'descripcion' => ['required', 'string'],
            'cantidad' => ['required', 'numeric'],
        ];
    }
    public function messages(): array
    {
        return [
            '*.required'=>'El campo :attribute es requerido',
            '*.string'=>'El campo :attribute debe ser un texto',
            '*.numeric'=>'El campo :attribute debe ser numerico',
        ];
    }
}
