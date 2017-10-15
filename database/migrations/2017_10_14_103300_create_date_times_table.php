<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDateTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_times', function (Blueprint $table) {
            $table->increments('id');
            $table->string("timezone")->default("utc");
            $table->timestamp("value");
            $table->string("role")->default("Primary");
            $table->integer("date_timable_id");
            $table->text("date_timable_type");
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
        Schema::dropIfExists('date_times');
    }
}
