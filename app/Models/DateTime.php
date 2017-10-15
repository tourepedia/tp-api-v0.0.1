<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateTime extends Model
{
    protected $table = "date_times";

    /**
     * Relationship: Get all the date_timable models
     */
    public function dateTimable()
    {
        return $this->morphTo();
    }
}
