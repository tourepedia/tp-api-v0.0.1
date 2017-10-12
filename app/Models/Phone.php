<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phone extends Model
{
    /**
     * Get all the owning phoneable models
     */
    public function phoneable()
    {
        return $this->morphTo();
    }
}
