<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


use App\Models\User;
use App\Models\MyBudgetItem;
use App\Models\MyBudgetCategory;
use App\Models\MyBudgetSection;
use App\Models\MyBudgetSource;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MyBudgetItemFactory extends Factory
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
                'price' => $this->faker->randomFloat(2, 10, 1000),
                'category_id' => MyBudgetCategory::factory()->for(User::factory()), // Automatically link to User
                'section_id' => MyBudgetSection::factory()->for(User::factory()),
                'source_id' => MyBudgetSource::factory()->for(User::factory()),
                'user_id' => User::factory(),
            ];
        }

        /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = MyBudgetItem::class;
}
