<?php

namespace App\Http\Requests\Import;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'api_key'   => ['required', 'string', Rule::in([env('1C_API_KEY')])],
            'data'      => ['required', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'api_key.required' => 'Необходимо передать API ключ!',
            'api_key.string' => 'API ключ - строковое значение!',
            'api_key.in' => 'Не верный ключ API!',
            'data.required' => 'Не найден массив "data" с данными выгрузки!',
        ];
    }
}