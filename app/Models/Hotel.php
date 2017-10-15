<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Constants\ConstantableTrait;

class Hotel extends Model
{
    use ConstantableTrait;

    protected $table = "hotels";

    /**
     * Get all location models
     */
    public function locations()
    {
        return $this->morphToMany("App\Models\Location", "locatable");
    }

    /**
     * Get all contacts models
     */
    public function contacts()
    {
        return $this->morphToMany("App\Models\Contact", "contactable");
    }

    /**
     * Get all of the room types
     */
    public function allRoomTypes()
    {
        return $this->morphToManyConstant('App\Models\Constants\HotelRoomType');
    }


    /**
     * Get active room types.
     */
    public function roomTypes()
    {
        return $this->allRoomTypes()->withPivot("is_active")->where("is_active", 1);
    }

    /**
     * Get all of the meal plans.
     */
    public function allMealPlans()
    {
        return $this->morphToManyConstant('App\Models\Constants\HotelMealPlan');
    }


    /**
     * Get active meal plans.
     */
    public function mealPlans()
    {
        return $this->allMealPlans()->withPivot("is_active")->where("is_active", 1);
    }

    /**
     * quotes
     */
    public function prices()
    {
        return $this->hasMany("App\Models\HotelPrice");
    }
}
