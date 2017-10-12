<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
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
}
