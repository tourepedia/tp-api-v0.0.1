<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelPrice extends Model
{
    use SoftDeletes;

    /**
     * Table name for the model
     * @var string
     */
    protected $table = "hotel_prices";


    protected static function boot()
    {
        parent::boot();


        static::addGlobalScope('withLocation', function (Builder $builder) {
            $builder->with("location");
        });

        static::addGlobalScope('withRoomType', function (Builder $builder) {
            $builder->with("roomType");
        });

        static::addGlobalScope('withMealPlan', function (Builder $builder) {
            $builder->with("mealPlan");
        });
    }

    public function hotel()
    {
        return $this->belongsTo("App\Models\Hotel");
    }

    /**
     * Get all location models
     */
    public function location()
    {
        return $this->belongsTo("App\Models\Location");
    }

    public function roomType()
    {
        return $this->belongsTo("App\Models\Tags\RoomType");
    }

    public function mealPlan()
    {
        return $this->belongsTo("App\Models\Tags\MealPlan");
    }
}
