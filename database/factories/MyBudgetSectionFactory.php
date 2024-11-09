<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MyBudgetSection;
use App\Models\MyBudgetCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MyBudgetSectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'category_id' => mybudget_category::factory(), // Automatically associate with a category
            'user_id' => User::factory(),
        ];
    }
}
