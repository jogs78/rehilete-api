<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
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
            'nombre'=>'required|string|max:255',
            'apellido'=>'required|string|max:255',
            'nombre_usuario'=>'required|string|max:255|unique:usuarios',
            'passw'=>'required|string|min:5|max:255',
            'rol'=>'required|in:Gerente,Cliente,Empleado',
            'fecha_nacimiento' => 'required|date_format:Y/m/d',
            'email'=>'required|email',
            'telefono' => 'required|regex:/^\+?\d+(?: \d+)*$/',
            'avatar' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
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
            'rol.in' => 'El rol seleccionado no es válido. Los roles permitidos son: Gerente, Cliente, Empleado.',
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
