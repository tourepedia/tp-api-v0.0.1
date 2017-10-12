<?php

namespace App\Models\Constants;

use Illuminate\Database\Eloquent\Model;
use App\Models\Constant;

class UserRole extends Constant
{

    use ConstantableTrait;

    /**
     * Attributes with some default values
     * @var array
     */
    protected $attributes = array(
        "type" => "role.user"
    );

    /**
     * Get all users associated with this role
     */
    public function allUser()
    {
        return $this->morphedByMany('App\Models\User', 'constantable');
    }


    /**
     * Get users which have this role as active role
     */
    public function users()
    {
        return $this->allUsers()->withPivot("is_active")->wherePivot("is_active", 1);
    }
}
