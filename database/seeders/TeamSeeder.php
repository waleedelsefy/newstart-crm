<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public $teams = [
        [
            'name' => 'A',
        ],
        [
            'name' => 'B',
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->teams as $team) {

            $user_id = $team['name'] == 'A' ? User::where('name', 'sales-team-leader')->first()->id :
                User::where('name', 'sales-manager')->first()->id;

            Team::create([
                ...$team,
                'user_id' => $user_id,
                'created_by' => User::whereIn('name', ['admin'])->pluck('id')->random(),
            ]);
        }
    }
}
