<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            // primary key
            $table->increments('id');

            $table->string("title")
                ->comment("Destinations overview of the trip");

            // trip start and end dates
            $table->timestamp("start_date")->nullable()
                ->comment("trip starting date");
            $table->integer("no_of_days")->nullable()
                ->comment("number of days for the trip");

            // source hold the souces of the trip
            // like onsite, offline, traveltriangle etc
            $table->string("source_id")->nullable()
                ->comment("source hold the souces of the trip like onsite, offline, tt");

            // type of people in the group
            $table->string("group_details")->nullable()
                ->comment("type of people in group like adults, children etc.");

            // creator / last updator of the trip in the database
            $table->integer("created_by")
                ->comment("creator of the trip in the database");
            $table->integer("last_updated_by")
                ->comment("last updator of the trip in the database");

            // time stamps
            $table->timestamps();

            // soft deletes
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
