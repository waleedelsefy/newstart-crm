<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BranchSeeder extends Seeder
{

    public $branches = [
        '6 October' => '6 اكتوبر',
        'Nasr City' => 'مدينة نصر',
        'Al Shihk Zaid' => 'الشيخ زايد',
        'Sharm Al Shihk' => 'شرم الشيخ',
        'Alexandria' => 'الاسكندرية',
        'Cairo' => 'القاهرة',
        'Haram' => 'الهرم',
        'Giza' => 'الجيزة',
        'Ain Shams' => 'عين شمس'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->branches as $branchEN => $branchAR) {

            Branch::withoutEvents(function () use ($branchEN, $branchAR) {
                Branch::create([
                    'name' => [
                        'en' => $branchEN,
                        'ar' => $branchAR,
                    ],
                    'slug' => Str::slug($branchEN),
                ]);
            });
        }
    }
}
