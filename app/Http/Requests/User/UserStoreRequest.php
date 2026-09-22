<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'email' => ['required', 'string', 'email', 'min:5', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'in:admin,user'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'phone' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Кастомные сообщения об ошибках на русском языке.
     */
    public function messages(): array
    {
        return [
            // Поле password
            'password.required'  => 'Поле «Пароль» обязательно для заполнения.',
            'password.string'    => 'Поле «Пароль» должно быть строкой.',
            'password.min'       => 'Пароль должен содержать не менее :min символов.',
            'password.confirmed' => 'Пароли не совпадают.',

            // Поле email
            'email.required' => 'Поле «Email» обязательно для заполнения.',
            'email.string'   => 'Поле «Email» должно быть строкой.',
            'email.email'    => 'Введите корректный адрес электронной почты.',
            'email.min'      => 'Email должен содержать не менее :min символов.',
            'email.max'      => 'Email не должен превышать :max символов.',
            'email.unique'   => 'Пользователь с таким email уже зарегистрирован.',

            // Поле name
            'name.required' => 'Поле «Имя» обязательно для заполнения.',
            'name.string'   => 'Поле «Имя» должно быть строкой.',
            'name.max'      => 'Имя не должно превышать :max символов.',

            // Поле role
            'role.required' => 'Поле «Роль» обязательно для заполнения.',
            'role.string'   => 'Поле «Роль» должно быть строкой.',
            'role.in'       => 'Роль должна быть одной из: :values.',

            // Поле phone
            'phone.string' => 'Поле «Телефон» должно быть строкой.',
            'phone.max'    => 'Телефон не должен превышать :max символов.',

            // Поле position
            'position.string' => 'Поле «Должность» должно быть строкой.',
            'position.max'    => 'Должность не должна превышать :max символов.',

            // Поле notes
            'notes.string' => 'Поле «Комментарий» должно быть строкой.',
        ];
    }

    /**
     * Русские названия атрибутов (для подстановки в сообщения).
     */
    public function attributes(): array
    {
        return [
            'password' => 'Пароль',
            'email'    => 'Email',
            'name'     => 'Имя',
            'role'     => 'Роль',
            'phone'    => 'Телефон',
            'position' => 'Должность',
            'notes'    => 'Комментарий',
        ];
    }
}
