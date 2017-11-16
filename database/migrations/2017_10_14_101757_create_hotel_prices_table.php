<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("hotel_id")->comment("hotel for which we have set this price");
            $table->integer("location_id")
                ->comment("location. we are not setting the hotel_location mapping here as that will be resolved while doing the fetch");
            $table->integer("room_type_id")
                ->comment("room type. we are not setting the hotel_room_type mapping here as that will be resolved while doing the fetch");
            $table->integer("meal_plan_id")
                ->comment("meal plan. we are not setting the hotel_room_type mapping here as that will be resolved while doing the fetch");
            $table->integer("base_price")->default(0)
                ->comment("Base price for the hotel where room type and meal plan.");
            $table->integer("base_price_plus")->default(0)
                ->comment("Base price variation in position value");
            $table->integer("base_price_minus")->default(0)
                ->comment("Base price variation in negative value");
            $table->integer("a_w_e_b")->default(0)
                ->comment("Adult with extra bed price");
            $table->integer("c_w_e_b")->default(0)
                ->comment("Child with extra bed price");
            $table->integer("c_wo_e_b")->default(0)
                ->comment("Child without with extra bed price");
            $table->timestamp("start_date");
            $table->timestamp("end_date");
            $table->integer("created_by");
            $table->softDeletes();
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
        Schema::dropIfExists('hotel_prices');
    }
}
