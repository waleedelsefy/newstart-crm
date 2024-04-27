<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $branchesIds = Branch::open()->get()->pluck('id')->toArray();
        $branchId = fake()->randomElement($branchesIds);

        $name = fake()->name();
        $username = Str::slug($name);
        $email = "$username@newstart.com";
        $countryCode = '+20';
        $phoneNumber = $countryCode . fake()->randomElement(['10', '11',  '12', '15']) . fake()->randomNumber(7);

        return [
            'branch_id' => $branchId,
            'name' => $name,
            'username' => Str::slug($name),
            'email' => $email,
            'phone_number' => $phoneNumber,
            'country_code' => $countryCode,
            'photo' => fake()->imageUrl(500, 500, 'avatar'),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
