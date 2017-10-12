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
            "contact" => \App\Contact::class,
            "user" => \App\User::class,
            "trip" => \App\Trip::class,
            "hotel" => \App\Hotel::class,
            "quote" => \App\Quote::class,
            "task" => \App\Task::class,
            "comment" => \App\Comment::class,
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
