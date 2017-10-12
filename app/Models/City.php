<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * Table name for the model
     * @var string
     */
    protected $table = "cities";


    public function state()
    {
        return $this->belongsTo("App\Models\State");
    }

    public function locations()
    {
        return $this->hasMany("App\Models\Location");
    }
}
