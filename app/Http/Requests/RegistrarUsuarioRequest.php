<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarUsuarioRequest extends FormRequest
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
        return array_merge($reglas,[
            'usuario_id' => ['required', 'exists:usuarios,id'],
//                'hora_fin' => ['nullable', 'integer', 'between:0,23'],
            'hora_fin' => ['nullable', 'date_format:H'],
            'precio' => ['nullable', 'numeric'],
        ]);
    }
    public function messages(): array
    {
        return [
            'nombre.required'=>'El nombre es requerido',
            'apellido.required'=>'Los apellidos son requeridos',
            'nombre_usuario.required'=>'El nombre de usuario es requerido',
            'nombre_usuario.unique' => 'El nombre de usuario se repite',
            'passw.required'=>'La contraseña es requerida',
            'passw.min'=>'La contraseña debe contener 5 caracteres',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'email'=>'El correo electronico debe ser una direccición valida',
            'telefono.regex' => 'El número de teléfono debe contener solo números, espacios y puede comenzar con un signo +.',
            'avatar.image' => 'El archivo subido debe ser una imagen.',
            'avatar.mimes' => 'Solo se permiten archivos JPEG, PNG y JPG.',
            'avatar.max' => 'El tamaño máximo permitido para el avatar es de 2MB.',            
            //
        ];
    }
}
