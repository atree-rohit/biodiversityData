<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpeciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('species', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("author")->nullable();
            $table->text("description")->nullable();
            $table->unsignedBigInteger("taxon_id");
            $table->unsignedBigInteger("limbo_data_id");
            $table->timestamps();

            $table->foreign('taxon_id')->references('id')->on('taxas')->onUpdate("cascade");
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
        Schema::dropIfExists('species');
    }
}
