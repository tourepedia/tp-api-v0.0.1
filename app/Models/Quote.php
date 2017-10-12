<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Quote extends Model
{
    /**
     * Table name
     * @var string
     */
    protected $table = "quotes";



    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderBy', function (Builder $builder) {
            $builder->orderBy("created_at", "DESC");
        });
    }



    /**
     * Get associted trip model
     */
    public function trip()
    {
        return $this->belongsTo("App\Models\Trip");
    }



    /**
     * Get associated prices
     */
    public function prices()
    {
        return $this->morphMany("App\Models\Price", "priceable")->where("prices.is_active", 1);
    }
}
