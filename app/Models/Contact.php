<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope("withPhones", function (Builder $builder) {
            $builder->with("phones");
        });
    }

    /**
     * Trips that belongs to the contact
     */
    public function hotels()
    {
        return $this->morphedByMany("App\Models\Hotel", "contactable");
    }

    /**
     * Phone numbers that belongs to the contact
     */
    public function phones()
    {
        return $this->morphMany("App\Models\Phone", "phoneable");
    }
}
