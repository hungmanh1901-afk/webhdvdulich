<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Location;
use Illuminate\Database\Seeder;

class LanguageLocationSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            'Tiếng Anh',
            'Tiếng Trung',
            'Tiếng Nhật',
            'Tiếng Hàn',
            'Tiếng Pháp',
        ];

        foreach ($languages as $name) {
            Language::firstOrCreate(['name' => $name]);
        }

        $locations = [
            ['name' => 'Hà Nội', 'description' => 'Thủ đô nghìn năm văn hiến'],
            ['name' => 'Đà Nẵng', 'description' => 'Thành phố biển miền Trung'],
            ['name' => 'Hạ Long', 'description' => 'Vịnh di sản thế giới'],
            ['name' => 'Sapa', 'description' => 'Ruộng bậc thang và văn hóa vùng cao'],
            ['name' => 'TP. Hồ Chí Minh', 'description' => 'Trung tâm kinh tế phía Nam'],
        ];

        foreach ($locations as $location) {
            Location::firstOrCreate(['name' => $location['name']], $location);
        }
    }
}
