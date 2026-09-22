<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class ImageStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'mimes:jpeg,jpg,png,webp,gif', 'max:4096'],
            'is_public' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'Выберите хотя бы одно изображение.',
            'images.array' => 'Некорректный формат загрузки.',
            'images.*.image' => 'Файл :position должен быть изображением.',
            'images.*.mimes' => 'Изображение :position должно быть в формате: jpeg, jpg, png, webp, gif.',
            'images.*.max' => 'Изображение :position не должно превышать :max килобайт.',
        ];
    }
}
