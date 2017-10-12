<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Constant extends Model
{
    /**
     * Table Name
     * @var string
     */
    protected $table = "constants";


    /**
     * Attributes with some default values
     * @var array
     */
    protected $attributes = array(
        "type" => "tag"
    );


    public static function boot()
    {
        parent::boot();

        static::addGlobalScope("forType", function (Builder $builder) {
            $builder->addType();
        });
    }

    public function scopeAddType($query)
    {
        if ($this->type) {
            return $query->where("type", $this->attributes["type"]);
        }

        return $query;
    }


    /**
     * Get all users associated with this constant
     */
    public function allUser()
    {
        return $this->morphedByMany('App\Models\User', 'constantable');
    }


    /**
     * Get all user with this constants as active
     */
    public function users()
    {
        return $this->allUsers()->withPivot("is_active")->wherePivot("is_active", 1);
    }
}
