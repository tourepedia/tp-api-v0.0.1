<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function country()
    {
        return $this->belongsTo("App\Models\Country");
    }

    public function state()
    {
        return $this->belongsTo("App\Models\State");
    }

    public function city()
    {
        return $this->belongsTo("App\Models\City");
    }

    /**
     * Get all the trips assigned to this location
     */
    public function trips()
    {
        return $this->morphedByMany("App\Models\Trip", "locatable");
    }
}
