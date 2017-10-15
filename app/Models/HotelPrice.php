<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Constants\ConstantableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelPrice extends Model
{
    use SoftDeletes;
    use ConstantableTrait;

    /**
     * Table name for the model
     * @var string
     */
    protected $table = "hotel_prices";


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('withPrices', function (Builder $builder) {
            $builder->with("prices");
        });

        static::addGlobalScope('withLocations', function (Builder $builder) {
            $builder->with("locations");
        });

        static::addGlobalScope('withRoomTypes', function (Builder $builder) {
            $builder->with("roomTypes");
        });

        static::addGlobalScope('withMealPlans', function (Builder $builder) {
            $builder->with("mealPlans");
        });
    }

    public function hotel()
    {
        return $this->belongsTo("App\Models\Hotel");
    }

    /**
     * Get all location models
     */
    public function locations()
    {
        return $this->morphToMany("App\Models\Location", "locatable");
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
     * Get associated prices
     */
    public function prices()
    {
        return $this->morphMany("App\Models\Price", "priceable")->where("prices.is_active", 1);
    }
}
