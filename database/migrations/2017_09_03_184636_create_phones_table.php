<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->increments("id");
            $table->string("country_code", 10)->default("+91");
            $table->string("phone_number", 20);
            $table->string("role")->default("Primary")
                ->comment("Role of the phone for the contact like primary, secondary etc");
            $table->integer("created_by");
            $table->boolean("is_active")->default(1)
                ->comment("Wether or not is entry is active. Used to maintain history.");
            $table->integer("phoneable_id");
            $table->text("phoneable_type");
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
        Schema::dropIfExists("phones");
    }
}
