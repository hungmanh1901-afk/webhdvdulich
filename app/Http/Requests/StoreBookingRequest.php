<?php

namespace App\Http\Requests;

use App\Models\Booking;
use App\Models\Guide;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isCustomer() ?? false;
    }

    public function rules(): array
    {
        return [
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.required' => 'Vui lòng chọn ngày bắt đầu.',
            'start_date.after_or_equal' => 'Ngày bắt đầu không được ở quá khứ.',
            'end_date.required' => 'Vui lòng chọn ngày kết thúc.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $guide = $this->route('guide');

            if (! $guide instanceof Guide || $guide->status !== Guide::STATUS_AVAILABLE) {
                $validator->errors()->add('guide', 'Hướng dẫn viên hiện không nhận đặt lịch.');

                return;
            }

            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $start = $this->input('start_date');
            $end = $this->input('end_date');

            $overlapping = fn (array $statuses) => Booking::query()
                ->where('guide_id', $guide->id)
                ->whereIn('status', $statuses)
                ->where('start_date', '<=', $end)
                ->where('end_date', '>=', $start);

            if ($overlapping([Booking::STATUS_CONFIRMED])->exists()) {
                $validator->errors()->add(
                    'start_date',
                    'Hướng dẫn viên đã có lịch đã xác nhận trong khoảng thời gian bạn chọn. Vui lòng chọn ngày khác.'
                );

                return;
            }

            if ($overlapping([Booking::STATUS_PENDING])->exists()) {
                $validator->errors()->add(
                    'start_date',
                    'Hướng dẫn viên đã có lịch chờ xác nhận trùng thời gian này. Vui lòng chọn ngày khác.'
                );
            }
        });
    }
}
