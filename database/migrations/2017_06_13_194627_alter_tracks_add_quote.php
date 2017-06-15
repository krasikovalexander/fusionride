<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Track;

class AlterTracksAddQuote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->string("quote")->nullable();
        });
        Track::whereNull('quote')->update(['quote'=>'']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropColumn("quote");
        });
    }
}
