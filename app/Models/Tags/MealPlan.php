<?php

namespace App\Models\Tags;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;

class MealPlan extends Tag
{
    protected $table = "meal_plans";

    /**
     * Get the hotels to which this meal plan is attched
     * @return [type] [description]
     */
    public function hotels()
    {
        return $this->belongsToMany("App\Models\Hotel", "hotel_meal_plan");
    }
}
