<?php

namespace Database\Factories;

use App\Models\mybudget_item;

use Illuminate\Database\Eloquent\Factories\Factory;


use App\Models\User;
use App\Models\mybudget_category;
use App\Models\mybudget_section;
use App\Models\mybudget_source;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ItemFactory extends Factory
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
                'category_id' => mybudget_category::factory()->for(User::factory()), // Automatically link to User
                'section_id' => mybudget_section::factory()->for(User::factory()),
                'source_id' => mybudget_source::factory()->for(User::factory()),
                'user_id' => User::factory(),
            ];
        }

        /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = mybudget_item::class;
}
