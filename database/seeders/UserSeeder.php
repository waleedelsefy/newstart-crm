<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Create an Owner user (Owner User = super administrator)
         */
        $user = User::create([
            'branch_id' => 1,
            'name' => 'Owner',
            'username' => 'owner',
            'email' => 'owner@crm.com',
            'phone_number' => '+201026053784',
            'country_code' => '+20',
            'owner' => 1,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $user->roles()->attach(Role::where('name', 'admin')->pluck('id')); // admin

        // Create a test user for each role
        foreach (Role::all() as $role) {
            $user = User::create([
                'branch_id' => 1,
                'name' => $role->name,
                'username' => $role->name,
                'email' => $role->name . '@crm.com',
                'phone_number' => '+20' . rand(1111111111, 9999999999),
                'country_code' => '+20',
                'owner' => 0,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);

            $user->roles()->attach($role->id);
        }

        // Create 10 random users
        // User::factory(10)->create();
        // $users = User::where('owner', 0)->get();

        // foreach ($users as $user) {
        //     $user->roles()->attach(rand(2, 4));
        // }
    }
}
