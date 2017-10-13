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
     * All Permissions associated with this
     */
    public function allPermissions()
    {
        return $this->morphMany("App\Models\Permission", 'permissionable');
    }

    /**
     * Only active Permissions associated with this
     */
    public function permissions()
    {
        return $this->allPermissions()->where("is_active", 1);
    }
}
