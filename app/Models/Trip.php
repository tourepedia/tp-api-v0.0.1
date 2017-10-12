<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use SoftDeletes;

    /**
     * Contact that belongs to this trip
     */
    public function contacts()
    {
        return $this->morphToMany("App\Models\Contact", "contactable");
    }

    /**
     * Creator of the trip
     */
    public function creator()
    {
        return $this->belongsTo("App\Models\User", "created_by", "id");
    }

    /**
     * Trips that belongs to the contact
     */
    public function locations()
    {
        return $this->morphToMany("App\Models\Location", "locatable");
    }

    /**
     * quotes
     */
    public function quotes()
    {
        return $this->hasMany("App\Quote");
    }
}
