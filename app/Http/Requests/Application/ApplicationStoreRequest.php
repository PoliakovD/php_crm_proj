<?php

namespace App\Http\Requests\Application;

use App\Enums\ApplicationStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'integer', Rule::in(ApplicationStatusEnum::values())],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Поле «Заголовок» обязательно для заполнения.',
            'title.max' => 'Заголовок не должен превышать :max символов.',
            'status.required' => 'Поле «Статус» обязательно для заполнения.',
            'status.in' => 'Указан некорректный статус.',
            'department_id.required' => 'Поле «Отдел» обязательно для заполнения.',
            'department_id.exists' => 'Выбранный отдел не найден.',
            'user_id.exists' => 'Выбранный пользователь не найден.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'status' => 'Статус',
            'department_id' => 'Отдел',
            'user_id' => 'Пользователь',
        ];
    }
}
