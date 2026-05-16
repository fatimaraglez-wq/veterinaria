<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:8|confirmed',
            'rol' => 'required|string|in:administrador,veterinario',
            'especialidad' => 'required_if:rol,veterinario|nullable|string|max:255',
            'cedula_profesional' => 'required_if:rol,veterinario|nullable|string|max:255',
            'nombre_completo' => 'required_if:rol,veterinario|nullable|string|max:255',
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de usuario es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debes ingresar un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está en uso por otro usuario.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'rol.required' => 'Debes seleccionar un rol para el usuario.',
            'rol.in' => 'El rol seleccionado no es válido.',
            'especialidad.required_if' => 'La especialidad es obligatoria al registrar un Veterinario.',
            'cedula_profesional.required_if' => 'La cédula es obligatoria al registrar un Veterinario.',
            'nombre_completo.required_if' => 'El nombre completo es obligatorio al registrar un Veterinario.',
        ];
    }
}
