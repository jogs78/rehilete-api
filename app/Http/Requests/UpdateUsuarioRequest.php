<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
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
            'nombre'=>'nullable|string|max:255',
            'apellido'=>'nullable|string|max:255',
            'nombre_usuario'=>'nullable|string|max:255',  
            'passw'=>'nullable|string|min:5|max:255',
            'rol'=>'nullable|in:Gerente,Cliente,Empleado',
            'fecha_nacimiento' => 'nullable|date_format:Y/m/d',
            'email'=>'nullable|email',
            'telefono' => 'nullable|regex:/^\+?\d+(?: \d+)*$/',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'passw.min'=>'La contraseña debe contener 5 caracteres',
            'rol.in' => 'El rol seleccionado no es válido. Los roles permitidos son: Gerente, Cliente, Empleado.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'email'=>'El correo electronico debe ser una direccición valida',
            'telefono.regex' => 'El número de teléfono debe contener solo números, espacios y puede comenzar con un signo +.',
            'avatar.image' => 'El archivo subido debe ser una imagen.',
            'avatar.mimes' => 'Solo se permiten archivos JPEG, PNG, JPG y WEBP.',
            'avatar.max' => 'El tamaño máximo permitido para el avatar es de 2MB.',            
            //
        ];
    }
}
