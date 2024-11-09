<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\mybudget_category;
use App\Models\mybudget_section;
use App\Models\mybudget_item;
use App\Models\mybudget_source;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()
            ->has(
                mybudget_item::factory()
                    ->for(mybudget_category::factory()->for($user), 'category')
                    ->for(mybudget_section::factory()->for($user), 'section')
                    ->for(mybudget_source::factory()->for($user), 'source')
            )
            ->create();
    }
}
