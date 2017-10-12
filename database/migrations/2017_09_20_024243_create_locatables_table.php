<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocatablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locatables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("location_id");
            $table->integer("locatable_id");
            $table->text("locatable_type");
            $table->integer("created_by");
            $table->boolean("is_active")->default(1)
                ->comment("Wether or not is entry is active. Used to maintain history.");
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
        Schema::dropIfExists('locatables');
    }
}
