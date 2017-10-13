<?php

namespace App\Models\Constants;

use Illuminate\Database\Eloquent\Model;
use App\Models\Constant;

class HotelRoomType extends Constant
{

    use ConstantableTrait;

    /**
     * Attributes with some default values
     * @var array
     */
    protected $attributes = array(
        "type" => "hotel.room_type"
    );

    /**
     * Get all hotels associated with this constant
     */
    public function allHotels()
    {
        return $this->morphedByManyConstant('App\Models\Hotel');
    }


    /**
     * Get all hotels with this constants as active
     */
    public function hotels()
    {
        return $this->allUsers()->withPivot("is_active")->wherePivot("is_active", 1);
    }
}
