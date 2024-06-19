<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' =>  fake()->numerify('INV-####'),             
            'invoice_date' => fake()->dateTime()->format('d-m-Y H:i:s'),
            //'email_verified_at' => now(),
            //'password' => static::$password ??= Hash::make('password'),
            //'remember_token' => Str::random(10),
            'invoice_amount' => fake()->randomFloat(2),
            'invoice_image' => fake()->imageUrl(640, 480, 'animals', true),
            'invoice_coverLetter_image' => fake()->imageUrl(640, 480, 'animals', true),
            'status' =>fake()->numberBetween(0,1),
            'user_id' => User::all()->random()->id,
        ];
    }
}
