<?php

namespace App\Http\Requests\Admin;

use App\Models\Guide;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $guideId = $this->route('guide')?->id;

        return [
            'full_name' => ['required', 'string', 'max:100'],
            'gender' => ['nullable', Rule::in([Guide::GENDER_MALE, Guide::GENDER_FEMALE, Guide::GENDER_OTHER])],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:100', Rule::unique('guides', 'email')->ignore($guideId)],
            'address' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:50'],
            'description' => ['nullable', 'string'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in([
                Guide::STATUS_AVAILABLE,
                Guide::STATUS_BUSY,
                Guide::STATUS_INACTIVE,
            ])],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'language_ids' => ['nullable', 'array'],
            'language_ids.*' => ['integer', 'exists:languages,id'],
            'location_ids' => ['nullable', 'array'],
            'location_ids.*' => ['integer', 'exists:locations,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Vui lòng nhập họ tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.unique' => 'Email đã được sử dụng.',
            'price_per_day.required' => 'Vui lòng nhập giá thuê mỗi ngày.',
            'avatar.image' => 'Ảnh đại diện phải là file hình ảnh.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',
        ];
    }
}
