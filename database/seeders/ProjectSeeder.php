<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public $projects = [
        [
            'name' => [
                'ar' => 'المشروع الاول',
                'en' => 'Project One'
            ],
        ],
        [
            'name' => [
                'ar' => 'المشروع الثاني',
                'en' => 'Project Two'
            ],
        ],
        [
            'name' => [
                'ar' => 'المشروع الثالث',
                'en' => 'Project Three'
            ],
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->projects as $project) {
            Project::create([
                ...$project,
                'developer_id' => Developer::pluck('id')->random(),
            ]);
        }
    }
}
