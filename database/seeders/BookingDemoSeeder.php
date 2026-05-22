<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Guide;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BookingDemoSeeder extends Seeder
{
    public function run(): void
    {
        $guides = Guide::all();
        if ($guides->isEmpty()) {
            return;
        }

        $customers = collect([
            ['full_name' => 'Nguyễn Văn An', 'email' => 'an.nguyen@demo.test', 'phone' => '0911111111'],
            ['full_name' => 'Trần Thị Bình', 'email' => 'binh.tran@demo.test', 'phone' => '0922222222'],
            ['full_name' => 'Lê Hoàng Cường', 'email' => 'cuong.le@demo.test', 'phone' => '0933333333'],
        ])->map(function ($data) {
            return User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'full_name' => $data['full_name'],
                    'password' => Hash::make('password'),
                    'phone' => $data['phone'],
                    'address' => 'Việt Nam',
                    'role' => User::ROLE_CUSTOMER,
                ]
            );
        });

        $statuses = [
            Booking::STATUS_PENDING,
            Booking::STATUS_CONFIRMED,
            Booking::STATUS_COMPLETED,
            Booking::STATUS_CANCELLED,
        ];

        foreach ($customers as $index => $customer) {
            foreach ($guides->take(2) as $guideIndex => $guide) {
                $monthsAgo = ($index + $guideIndex) % 6;
                $start = Carbon::now()->subMonths($monthsAgo)->addDays(rand(1, 10));
                $end = $start->copy()->addDays(rand(1, 4));
                $days = $start->diffInDays($end) + 1;
                $status = $statuses[($index + $guideIndex) % count($statuses)];

                Booking::firstOrCreate(
                    [
                        'user_id' => $customer->id,
                        'guide_id' => $guide->id,
                        'start_date' => $start->toDateString(),
                        'end_date' => $end->toDateString(),
                    ],
                    [
                        'booking_date' => $start->copy()->subDays(2)->toDateString(),
                        'total_price' => $guide->price_per_day * $days,
                        'note' => 'Lịch đặt demo cho hệ thống thống kê.',
                        'status' => $status,
                        'created_at' => $start->copy()->subDays(3),
                    ]
                );
            }
        }
    }
}
