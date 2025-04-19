<?php

namespace App\Http\Requests\Assignment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'mentor_id' => ['required', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Пользователь обязателен для выбора.',
            'user_id.exists' => 'Указанный пользователь не найден.',
            'mentor_id.required' => 'Наставник обязателен для выбора.',
            'mentor_id.exists' => 'Указанный наставник не найден.',
        ];
    }
}
