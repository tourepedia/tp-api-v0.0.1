<?php

namespace App\Models\Tags;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;

class UserRole extends Tag
{

    protected $table="user_roles";

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
