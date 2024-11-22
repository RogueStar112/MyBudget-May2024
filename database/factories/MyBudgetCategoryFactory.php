<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\mybudget_category;

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
            'name' => faker()->word,
            'created_at' => faker()->date(),
            'updated_at' => faker()->date(),
            'color_bg' => faker()->safeHexColor(),
            'color_text' => faker()->safeHexColor(),
            'icon_code' => "&#xf02d;", // placeholder icon
            'user_id' => User::factory()
        ];
    }
}
