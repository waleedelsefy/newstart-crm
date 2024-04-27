<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{

    public $events = [
        [
            'name' => 'fresh',
        ],
        [
            'name' => 'no-action',
        ],
        [
            'name' => 'follow-up',
            'with_date' => 'yes',
            'with_notes' => 'yes',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->events as $event) {
            Event::create($event);
        }
    }
}
