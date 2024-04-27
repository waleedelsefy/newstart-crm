<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{

    public $sources = [
        [
            'name' => [
                'ar' => 'فيسبوك',
                'en' => 'facebook'
            ],
        ],
        [
            'name' => [
                'ar' => 'انستاجرام',
                'en' => 'instagram'
            ],
        ],
        [
            'name' => [
                'ar' => 'تويتر',
                'en' => 'twitter'
            ],
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->sources as $source) {
            Source::create($source);
        }
    }
}
