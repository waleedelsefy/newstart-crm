<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Interest;
use App\Models\Lead;
use App\Models\LeadHistory;
use App\Models\Source;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public $leads = [
        [
            'name' => 'Lead 1',
            'slug' => 'lead-1',
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 0; $i < 5; $i++) {
            $number = $i + 1;
            $user_id = User::whereIn('name', ['admin', 'marketing'])->pluck('id')->random();

            $lead = new Lead();
            $lead->name = 'Lead ' . $number;
            $lead->branch_id = Branch::pluck('id')->random();
            $lead->created_by = $user_id;
            $lead->event_created_at = now();
            $lead->event_created_by = $user_id;
            $lead->saveQuietly();

            $lead->interests()->attach(Interest::pluck('id')->random());
            $lead->sources()->attach(Source::pluck('id')->random());

            $lead->histories()->create([
                'type' => 'created',
                'info' => [
                    'en' => "test",
                    'ar' => "test"
                ],
                'user_id' => $user_id,
                'notes' => $lead->notes,
            ]);
        }
    }
}
