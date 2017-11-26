<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        "password",
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * Phone numbers that belongs to the contact
     */
    public function phones()
    {
        return $this->morphMany("App\Models\Phone", "phoneable");
    }


    /**
     * Get all of the roles for the user.
     */
    public function allRoles()
    {
        return $this->belongsToMany("App\Models\Tags\UserRole", "user_role_pivot");
    }


    /**
     * Get active roles for the user.
     */
    public function roles()
    {
        return $this->allRoles()->withPivot("is_active");
    }

    /**
     * get all the tasks assigned to the user
     * fix: update the binding from created_by to assigned_to
     */
    public function allTasks()
    {
        return $this->belongsToMany("App\Models\Task", "task_assignee", "user_id", "task_id")->withPivot("is_active");
    }

    public function tasks()
    {
        return $this->allTasks()->wherePivot("is_active", 1);
    }
}
