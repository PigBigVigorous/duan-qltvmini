<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Tạo số bản copy ngẫu nhiên
        $totalCopies = $this->faker->numberBetween(5, 20);
        
        return [
            'title' => $this->faker->sentence(4), // Tiêu đề ngẫu nhiên
            'author' => $this->faker->name(), // Tên tác giả ngẫu nhiên
            'publication_year' => $this->faker->year(), // Năm ngẫu nhiên
            'total_copies' => $totalCopies,
            'available_copies' => $this->faker->numberBetween(0, $totalCopies), // Số tồn kho ngẫu nhiên
        ];
    }
}