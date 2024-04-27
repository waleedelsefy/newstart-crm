<?php

namespace Database\Seeders;

use App\Models\Developer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    public $developers = [
        [
            'name' => [
                'ar' => 'نيو ستارت',
                'en' => 'New start'
            ],
        ],
        [
            'name' => [
                'ar' => 'مطور اخر',
                'en' => 'Other Developer'
            ],
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->developers as $developer) {
            Developer::create($developer);
        }
    }
}
