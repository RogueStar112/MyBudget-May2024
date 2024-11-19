<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\MyBudgetCategory;
use App\Models\MyBudgetSection;
use App\Models\MyBudgetItem;
use App\Models\MyBudgetSource;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        $user = User::factory()->create();

        // Create related data for the user
        MyBudgetItem::factory()
            ->for(MyBudgetCategory::factory()->for($user), 'category')
            ->for(MyBudgetSection::factory()->for($user), 'section')
            ->for(MyBudgetSource::factory()->for($user), 'source')
            ->create(['user_id' => $user->id]);
    }
}
