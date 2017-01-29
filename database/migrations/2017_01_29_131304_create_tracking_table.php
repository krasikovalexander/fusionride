<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('request_id')->unsigned();
            $table->integer('provider_id')->unsigned();
            $table->enum('result', ['No response', 'Yes', 'No', 'May be'])->default('No response');
            $table->string('price')->nullable();
            $table->string('notes', 200)->nullable();
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
    }
}
