<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Constants\ConstantableTrait;

class Constant extends Model
{
    use ConstantableTrait;

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
    public function allUsers()
    {
        return $this->morphedByManyContant('App\Models\User');
    }


    /**
     * Get all user with this constants as active
     */
    public function users()
    {
        return $this->allUsers()->withPivot("is_active")->wherePivot("is_active", 1);
    }
}
