<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEventoRequest extends FormRequest
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
        $reglas = [
            'nombre' => 'required',
            'paquete_id' => 'required|exists:paquetes,id',
            'fecha' => ['required', 'date', 'date_format:Y-m-d'],
            //            'hora_inicio' => ['required', 'integer', 'between:0,23'],
            'hora_inicio' => ['required', 'regex:/^(2[0-3]|[01]?[0-9])(:[0-5][0-9])?$/'],
            'descripcion' => 'required',
            'num_personas' => ['required', 'integer', 'between:1,100'],
            'servicios' => 'nullable|array', // Permite que 'servicios' sea nulo o un arreglo
            'servicios.*' => 'exists:servicios,id', // Cada elemento debe existir en la tabla 'servicios'
        ];
        if (Auth::user()->rol == 'Cliente') {
            return $reglas;
        } else {
            return array_merge($reglas, [
                'usuario_id' => ['required', 'exists:usuarios,id'],
                //                'hora_fin' => ['nullable', 'integer', 'between:0,23'],
                'hora_fin' => ['nullable', 'regex:/^(2[0-3]|[01]?[0-9])(:[0-5][0-9])?$/'],
                'precio' => ['nullable', 'numeric'],
            ]);
        }

    }

    public function messages()
    {
        return [
            '*.required' => 'El campo :attribute es requerido',
            'fecha.date' => 'El campo :attribute debe ser una fecha valida',
            'fecha.date_format' => 'El campo :attribute debe cumplir el formato Año-Mes-Dia de la forma aaa-mm-dd',
            '*.regex' => 'La :attribute debe de indicarse en formato como un entero o en formato HH:SS',
            '*.integer' => 'El campo :attribute debe ser un entero',
            '*.between' => 'El valor del campo :attribute debe estar entre :min y :max inclusive',
            'servicios.array' => 'El campo servicios debe ser un arreglo.',
            'servicios.*.exists' => 'Uno o más elementos de servicios no son válidos.',
            '*.exists' => 'El valor proporcionado en el campo :attribute no se encuentra registrado.',
        ];
    }

    public function attributes()
    {
        return [
            'hora_inicio' => 'hora de inicio',
            'hora_fin' => 'hora de finalización',
            'num_personas' => 'número de personas',
            'usuario_id' => 'usuario del evento',
            'paquete_id' => 'paquete del evento',
        ];
    }
}
