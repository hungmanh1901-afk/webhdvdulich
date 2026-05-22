<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $languageId = $this->route('language')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('languages', 'name')->ignore($languageId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên ngôn ngữ.',
            'name.unique' => 'Ngôn ngữ này đã tồn tại.',
            'name.max' => 'Tên ngôn ngữ không được vượt quá 50 ký tự.',
        ];
    }
}
