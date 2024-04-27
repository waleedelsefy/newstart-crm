<?php

namespace Database\Seeders;

use App\Models\Interest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    public $interests = [
        [
            'name' => [
                'ar' => 'تجريبي',
                'en' => 'test'
            ],
        ],
        [
            'name' => [
                'ar' => 'شقة',
                'en' => 'Apartment'
            ],
        ],
        [
            'name' => [
                'ar' => 'شقة دوبلكس',
                'en' => 'Duplex Apartment'
            ],
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->interests as $interest) {
            Interest::create($interest);
        }
    }
}
