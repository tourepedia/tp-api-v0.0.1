<?php

namespace App\Models\Tags;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;

class RoomType extends Tag
{
    protected $table = "room_types";

    /**
     * Get the hotels to which this room type is mapped
     * @return [type] [description]
     */
    public function hotels()
    {
        return $this->belongsToMany("App\Models\Hotel", "hotel_room_type");
    }
}
