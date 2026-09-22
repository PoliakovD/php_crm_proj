<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ContactSubject;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'email'    => ['required', 'string', 'email', 'min:5', 'max:255', 'unique:users,email,' . $this->route()->parameter('user')->id],
            'name'     => ['required', 'string', 'max:255'],
            'role'     => ['required', 'string', 'max:255', 'in:admin,user'],
            'avatar'   => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],

            // Контакты
            'contact_types'           => ['sometimes', 'array'],
            'contact_types.*.id'      => ['required', 'integer', 'exists:contact_types,id'],
            'contact_types.*.subject' => [
                'required', 'string', 'max:255',
                new ContactSubject(),
            ],

            'phone'    => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'notes'    => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique'                => 'Такая почта уже существует!',
            'password.confirmed'          => 'Пароли не совпадают!',
            'contact_types.*.id.required' => 'Укажите тип контакта.',
            'contact_types.*.id.exists'   => 'Такого типа контакта не существует.',
            'contact_types.*.subject.required' => 'Введите значение контакта.',
            'contact_types.*.subject.max'      => 'Значение контакта не должно превышать :max символов.',
        ];
    }
}
