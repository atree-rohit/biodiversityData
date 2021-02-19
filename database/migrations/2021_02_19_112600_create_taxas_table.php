<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxas', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->text("description")->nullable();
            $table->string("level")->nullable();
            $table->unsignedBigInteger("limbo_data_id")->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('taxas')->onUpdate("cascade");
            $table->foreign('limbo_data_id')->references('id')->on('limbo_data')->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxas');
    }
}
