<?php

namespace App\Http\Requests\Talk;

use Illuminate\Foundation\Http\FormRequest;

class StoreTalkRequest extends FormRequest
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
            'assignment_id' => ['required', 'exists:assignments,id'],
            'file' => ['required'],
            'user_comment' => ['max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'assignment_id.required' => 'Не указано назначение.',
            'assignment_id.exists' => 'Неверное назначение.',
            'file.required' => 'Файл обязателен к загрузке.',
            'user_comment.max' => 'Кол-во символов не должно превышать 1000.',
        ];
    }
}
