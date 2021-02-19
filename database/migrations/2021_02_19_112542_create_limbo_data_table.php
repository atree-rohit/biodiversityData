<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLimboDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('limbo_data', function (Blueprint $table) {
            $table->id();
            $table->string("range");
            $table->binary("text");
            $table->text("changes");
            $table->unsignedBigInteger("document_id");
            $table->timestamps();

            $table->foreign('document_id')->references('id')->on('documents')->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('limbo_data');
    }
}
