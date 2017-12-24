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
        static::addGlobalScope("withAssignees", function (Builder $builder) {
            $builder->with("assignees");
        });

        static::addGlobalScope("orderByCreatedAt", function (Builder $builder) {
            $builder->orderby("created_at", "DESC");
        });
    }

    public function author()
    {
        return $this->belongsTo("App\Models\User", "created_by");
    }

    public function allAssignees()
    {
        return $this->belongsToMany("App\Models\User", "task_assignee", "task_id", "user_id")->withPivot("is_active");
    }

    public function assignees()
    {
        return $this->allAssignees()->wherePivot("is_active", 1);
    }
}
