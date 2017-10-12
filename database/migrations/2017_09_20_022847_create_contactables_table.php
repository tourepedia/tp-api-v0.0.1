<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("contact_id");
            $table->integer("contactable_id");
            $table->text("contactable_type");
            $table->string("contact_role")->default("Primary")
                ->comment("Role of the contact for the trip like primary, secondary etc.");
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
        Schema::dropIfExists('contactables');
    }
}
