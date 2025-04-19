<?php

namespace App\Http\Requests\Talk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTalkRequest extends FormRequest
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
            'file' => ['nullable', 'file'],
            'user_comment' => ['max:1000'],
            'mentor_comment' => ['max:1000'],
            'status' => ['nullable', 'in:pending,reviewed,approved,rejected'],
        ];
    }

    public function messages(): array
    {
        return [
            'assignment_id.required' => 'Не указано назначение.',
            'assignment_id.exists' => 'Неверное назначение.',
            'user_comment.max' => 'Кол-во символов не должно превышать 1000.',
        ];
    }
}
