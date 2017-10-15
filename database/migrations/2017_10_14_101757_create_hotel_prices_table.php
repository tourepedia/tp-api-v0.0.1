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
            $table->integer("hotel_id");
            $table->integer("adults_with_extra_bed")->default(0);
            $table->integer("children_with_extra_bed")->default(0);
            $table->integer("children_without_extra_bed")->default(0);
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
