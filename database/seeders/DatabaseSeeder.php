<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Branch;
use App\Models\Developer;
use App\Models\Event;
use App\Models\Interest;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Source;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BranchSeeder::class,
            CountrySeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            InterestSeeder::class,
            SourceSeeder::class,
            DeveloperSeeder::class,
            ProjectSeeder::class,
            EventSeeder::class,
            LeadSeeder::class,
            TeamSeeder::class,
        ]);
    }
}
