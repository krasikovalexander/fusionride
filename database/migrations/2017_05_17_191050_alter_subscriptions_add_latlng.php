<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Subscription;

class AlterSubscriptionsAddLatlng extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Subscription::whereNotNull('id')->delete();

        Schema::disableForeignKeyConstraints();
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign('subscriptions_state_id_foreign');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('state_id');
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
        Schema::table('subscriptions', function (Blueprint $table) {
            //
        });
    }
}
