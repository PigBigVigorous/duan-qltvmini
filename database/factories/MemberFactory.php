<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ma_doc_gia' => 'DG' . $this->faker->unique()->numberBetween(1000, 9999), // Mã độc giả ngẫu nhiên
            'ten_doc_gia' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'dien_thoai' => $this->faker->phoneNumber(),
            'dia_chi' => $this->faker->address(),
        ];
    }
}