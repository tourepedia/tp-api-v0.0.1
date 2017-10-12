<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("trip_id")->comment("Trip to which this quotes belongs");

            // short itinerary for the trip
            $table->text("short_itinerary")->nullable()
                ->comment("short itinerary for the trip journey");

            // hotels details
            $table->text("hotels_details")->nullable()
                ->comment("hotel details for the trip like hotel name, location, room type etc.");

            // travel details
            $table->text("travel_details")->nullable()
                ->comment("travel details for the trips like cabs, flights, trains details etc.");

            // comments
            $table->text("comments")->nullable()
                ->comment("any additional information for the trip");

            // time stamps
            $table->boolean("is_active")->default(1)
                ->comment("Wether or not this quote is active");
            $table->integer("created_by")
                ->comment("creator of the trip in the database");
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
        Schema::dropIfExists('quotes');
    }
}
