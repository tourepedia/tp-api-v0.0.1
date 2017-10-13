<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class PolymorphicMapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            "contact" => \App\Models\Contact::class,
            "user" => \App\Models\User::class,
            "trip" => \App\Models\Trip::class,
            "hotel" => \App\Models\Hotel::class,
            "quote" => \App\Models\Quote::class,
            "task" => \App\Models\Task::class,
            "comment" => \App\Models\Comment::class,
            "constant" => \App\Models\Constant::class,
            "user_role" => \App\Models\Constants\UserRole::class,
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
