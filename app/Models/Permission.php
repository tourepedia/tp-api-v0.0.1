<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    /**
     * Get all the trips assigned to this location
     */
    public function permissionable()
    {
        return $this->morphTo();
    }
}
