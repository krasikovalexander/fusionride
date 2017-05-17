<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRequestsAddLatlng extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign('requests_state_foreign');
        });

        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->double("lat");
            $table->double("lng");
            $table->double("r");
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
        });
    }
}
