<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$api = $app->make(Dingo\Api\Routing\Router::class);

$api->version('v1', function ($api) {
    $api->post('/auth/login', [
        'as' => 'api.auth.login',
        'uses' => 'App\Http\Controllers\Auth\AuthController@postLogin',
    ]);

    $api->group([
        'middleware' => 'api.auth',
    ], function ($api) {
        $api->get('/', [
            'uses' => 'App\Http\Controllers\APIController@getIndex',
            'as' => 'api.index'
        ]);
        $api->get('/auth/user', [
            'uses' => 'App\Http\Controllers\Auth\AuthController@getUser',
            'as' => 'api.auth.user'
        ]);
        $api->patch('/auth/refresh', [
            'uses' => 'App\Http\Controllers\Auth\AuthController@patchRefresh',
            'as' => 'api.auth.refresh'
        ]);
        $api->delete('/auth/invalidate', [
            'uses' => 'App\Http\Controllers\Auth\AuthController@deleteInvalidate',
            'as' => 'api.auth.invalidate'
        ]);


        /**
         * Routes for User resource
         */
        $api->get("/users", [
            "uses" => "App\Http\Controllers\UsersController@index",
            "as" => "api.users.index"
        ]);
        $api->post("/users", [
            "uses" => "App\Http\Controllers\Auth\RegisterController@register",
            "as" => "api.users.store"
        ]);
        $api->get("/users/{user}", [
            "uses" => "App\Http\Controllers\UsersController@show",
            "as" => "api.users.show"
        ]);
        $api->post("/users/{user}/update-roles", [
            "uses" => "App\Http\Controllers\UsersController@updateRoles",
            "as" => "api.users.update-roles"
        ]);

        /**
         * Routes for Roles
         */
        $api->get("/roles", [
            "uses" => "App\Http\Controllers\Tags\UserRolesController@index",
            "as" => "api.user-roles.index"
        ]);
        $api->post("/roles", [
            "uses" => "App\Http\Controllers\Tags\UserRolesController@store",
            "as" => "api.user-roles.store"
        ]);
        $api->get("/roles/{role}", [
            "uses" => "App\Http\Controllers\Tags\UserRolesController@show",
            "as" => "api.user-roles.show"
        ]);
        $api->post("/roles/{role}/update-permissions", [
            "uses" => "App\Http\Controllers\Tags\UserRolesController@updatePermissions",
            "as" => "api.user-roles.update-permissions"
        ]);

        /**
         * Routes for permissions
         */
        $api->get("/permissions/{for}", [
            "uses" => "App\Http\Controllers\PermissionsController@index",
            "as" => "api.permissions.index"
        ]);

        /**
         * Routes for Contact resource
         */
        $api->get("/contacts", [
            "uses" => "App\Http\Controllers\ContactsController@index",
            "as" => "api.contacts.index"
        ]);
        $api->post("/contacts", [
            "uses" => "App\Http\Controllers\ContactsController@store",
            "as" => "api.contacts.store"
        ]);
        $api->get("/contacts/{contact}", [
            "uses" => "App\Http\Controllers\ContactsController@show",
            "as" => "api.contacts.show"
        ]);


        /**
         * Routes for Hotel resource
         */
        $api->get("/hotels", [
            "uses" => "App\Http\Controllers\HotelsController@index",
            "as" => "api.hotels.index"
        ]);
        $api->post("/hotels", [
            "uses" => "App\Http\Controllers\HotelsController@store",
            "as" => "api.hotels.store"
        ]);
        $api->get("/hotels/search", [
            "uses" => "App\Http\Controllers\HotelsController@search",
            "as" => "api.hotels.search"
        ]);
        $api->get("/hotels/{hotel}", [
            "uses" => "App\Http\Controllers\HotelsController@show",
            "as" => "api.hotels.show"
        ]);
        $api->post("/hotels/{hotel}/add-contact", [
            "uses" => "App\Http\Controllers\HotelsController@storeContact",
            "as" => "api.hotels.add-contact"
        ]);
        $api->post("/hotels/{hotel}/add-price", [
            "uses" => "App\Http\Controllers\HotelsController@storePrice",
            "as" => "api.hotels.add-price"
        ]);

        // hotel room types
        $api->get("/hotel-room-types", [
            "uses" => "App\Http\Controllers\Tags\RoomTypesController@index",
            "as" => "api.hotel-room-types.index"
        ]);
        $api->post("/hotel-room-types", [
            "uses" => "App\Http\Controllers\Tags\RoomTypesController@store",
            "as" => "api.hotel-room-types.store"
        ]);
        $api->get("/hotel-room-types/{roomType}", [
            "uses" => "App\Http\Controllers\Tags\RoomTypesController@show",
            "as" => "api.hotel-room-types.show"
        ]);

        // hotel meal plans
        $api->get("/hotel-meal-plans", [
            "uses" => "App\Http\Controllers\Tags\MealPlansController@index",
            "as" => "api.hotel-room-types.index"
        ]);
        $api->post("/hotel-meal-plans", [
            "uses" => "App\Http\Controllers\Tags\MealPlansController@store",
            "as" => "api.hotel-room-types.store"
        ]);
        $api->get("/hotel-meal-plans/{mealPlan}", [
            "uses" => "App\Http\Controllers\Tags\MealPlansController@show",
            "as" => "api.hotel-meal-plans.show"
        ]);

        /**
         * Routes for locations
         */
        $api->get("/locations", [
            "uses" => "App\Http\Controllers\LocationsController@index",
            "as" => "api.locations.index"
        ]);

        /**
         * Routes for Tasks
         */
        $api->get("/tasks", [
            "uses" => "App\Http\Controllers\TasksController@index",
            "as" => "api.tasks.index"
        ]);
        $api->post("/tasks", [
            "uses" => "App\Http\Controllers\TasksController@store",
            "as" => "api.tasks.store"
        ]);
        $api->get("/tasks/{task}", [
            "uses" => "App\Http\Controllers\TasksController@show",
            "as" => "api.tasks.show"
        ]);
    });
    $api->get("/pusher", function () {
        event(new App\Events\TaskAssignmentEvent('Hi, Task assigned to you.'));
        return "Event has been sent!";
    });
});
