<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MyBudgetCategory;

use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MyBudgetCategoryFactory extends Factory
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
            'created_at' => $this->faker->date(),
            'updated_at' => $this->faker->date(),
            'color_bg' => $this->faker->safeHexColor(),
            'color_text' => $this->faker->safeHexColor(),
            'icon_code' => "&#xf02d;", // placeholder icon
            'user_id' => User::factory()
        ];
    }

    protected $model = MyBudgetCategory::class;
}
