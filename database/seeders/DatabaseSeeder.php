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
        
        for ($i = 0;  $i < 5; $i++) {
            $category = MyBudgetCategory::factory()->create(['user_id' => $user->id]);
            
            $section = MyBudgetSection::factory()->create(['user_id' => $user->id, 'category_id' => $category->id]);

            $source = MyBudgetSource::factory()->create(['user_id' => $user->id]);


            // Create related data for the user

            
            
            for ($ii = 0;  $ii < random_int(4, 8); $ii++) {
            MyBudgetItem::factory()
                ->create(['category_id' => $category->id, 
                        'section_id' => $section->id, 
                        'source_id' => $source->id, 
                        'user_id' => $user->id]);
            }
        }
    }
}
