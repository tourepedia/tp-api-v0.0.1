<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConstantablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constantables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("constant_id");
            $table->integer("constantable_id");
            $table->string("constantable_type");
            $table->integer("created_by");
            $table->boolean("is_active")->default(1);
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
        Schema::dropIfExists('constantables');
    }
}
