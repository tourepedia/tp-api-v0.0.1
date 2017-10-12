<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');
            $table->string("currency")->default("INR");
            $table->integer("value");
            $table->integer("created_by");
            $table->boolean("is_active")->default(1)
                ->comment("Wether or not is entry is active. Used to maintain history.");
            $table->integer("priceable_id");
            $table->text("priceable_type");
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
        Schema::dropIfExists('prices');
    }
}
