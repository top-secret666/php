<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле имя обязательно для заполнения',
            'email.required' => 'Поле email обязательно',
            'email.email' => 'Введите корректный email адрес',
            'email.unique' => 'Пользователь с таким email уже зарегистрирован',
            'password.required' => 'Поле пароль обязательно',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
            'password.confirmed' => 'Подтверждение пароля не совпадает',
        ];
    }
}
