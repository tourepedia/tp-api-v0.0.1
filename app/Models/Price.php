<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = "prices";

    /**
     * Relationship: Get all the priceable models
     */
    public function priceable()
    {
        return $this->morphTo();
    }
}
