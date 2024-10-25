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
        if(Auth::user()->rol == 'Cliente')
            return [
                'nombre' => 'required',
                'paquete_id' => 'required|exists:paquetes,id',
                'fecha' => ['required', 'date', 'date_format:Y-m-d'],
                'hora_inicio' => ['required', 'integer', 'between:0,23'],
//                'hora_inicio' => ['required', 'date_format:H'],
                'descripcion' => 'required',
                'num_personas' => ['required', 'integer', 'between:1,100'],
                'servicios' => 'nullable|array', // Permite que 'servicios' sea nulo o un arreglo
                'servicios.*' => 'exists:servicios,id', // Cada elemento debe existir en la tabla 'servicios'
            ];
        else
            return [
                'nombre' => 'required',
                'usuario_id' => ['required', 'exists:usuarios,id'],
                'paquete_id' => 'required|exists:paquetes,id',
                'fecha' => ['required', 'date', 'date_format:Y-m-d'],
                'hora_inicio' => ['required', 'integer', 'between:0,23'],
//                'hora_inicio' => ['required', 'date_format:H'],
                'hora_fin' => ['nullable', 'integer', 'between:0,23'],
                'descripcion' => 'required',
                'num_personas' => ['required', 'integer', 'between:1,100'],
                'servicios' => 'nullable|array', // Permite que 'servicios' sea nulo o un arreglo
                'servicios.*' => 'exists:servicios,id', // Cada elemento debe existir en la tabla 'servicios'
            ];
    }

    public function messages()
    {
        return [
            '*.required' => 'El campo :attribute es requerido',
            'fecha.date' => 'El campo :attribute debe ser una fecha valida',
            'fecha.date_format' => 'El campo :attribute debe cumplir el formato Año-Mes-Dia de la forma aaa-mm-dd',
            'hora_inicio.date_format' => 'La hora de inicio debe de inicarse',
            '*.integer' =>  'El campo :attribute debe ser un entero',
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
