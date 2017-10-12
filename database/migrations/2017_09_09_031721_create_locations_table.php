<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("city_id")->nullable();
            $table->integer("state_id")->nullable();
            $table->integer("country_id");
            $table->string("short_name")
                ->comment("This hold the first preferred name of the locations. For example, if location is City, State, Country then the short name will be City. And if location is State, Country then the short name will be State.");
            $table->string("name")
                ->comment("Name of the location with join(city_name, state_name, country_name)");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
