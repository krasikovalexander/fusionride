<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('state')->unsigned();
            $table->string('city');
            $table->boolean('drive')->default(false);
            $table->enum('pickup', ['airport','business','home','apartment']);
            $table->string('pickup_date');
            $table->string('pickup_time');
            $table->enum('dropoff', ['airport','business','home','apartment'])->nullable();
            $table->string('dropoff_date')->nullable();
            $table->string('dropoff_time')->nullable();
            $table->boolean('type')->default(false);
            $table->integer('car')->unsigned()->nullable();
            $table->integer('custom_passengers_min')->nullable();
            $table->integer('custom_passengers_max')->nullable();
            $table->string('custom_type')->nullable();
            $table->boolean('black')->default(false);
            $table->boolean('white')->default(false);
            $table->boolean('red')->default(false);
            $table->boolean('yellow')->default(false);
            $table->boolean('green')->default(false);
            $table->boolean('blue')->default(false);
            $table->boolean('alcohol')->default(false);
            $table->enum('event', ['party','wedding','meet','tour','graduation','sport','holiday','other']);
            $table->string('description')->nullable();
            $table->string('email');
            $table->string('phone');

            $table->foreign('car')->references('id')->on('types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('state')->references('id')->on('states')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('requests');
    }
}
