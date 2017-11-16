<?php

use Illuminate\Database\Seeder;

class MealPlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $mealPlans = [
        "MAP" => "Modified American Plan (Two meals: Breakfast and one of Lunch or Dinner)",
        "CP" => "Continental Plan (Breakfast)",
        "AP" => "Breakfast+Lunch+Dinner",
        "EP" => "Room Only",
    ];
    public function run()
    {
        foreach ($this->mealPlans as $name => $description) {
            $mealPlan = new App\Models\Tags\MealPlan();
            $mealPlan->name = $name;
            $mealPlan->description = $description;
            $mealPlan->created_by = 1;
            $mealPlan->save();
        }
    }
}
