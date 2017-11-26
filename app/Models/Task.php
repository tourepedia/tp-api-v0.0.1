<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope("withAuthor", function (Builder $builder) {
            $builder->with("author");
        });

        static::addGlobalScope("orderByCreatedAt", function (Builder $builder) {
            $builder->orderby("created_at", "DESC");
        });
    }

    public function author () {
        return $this->belongsTo("App\Models\User", "created_by");
    }
}
