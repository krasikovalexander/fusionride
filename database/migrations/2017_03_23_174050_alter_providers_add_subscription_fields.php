<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Provider;

class AlterProvidersAddSubscriptionFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->enum('subscription_status', ['none', 'pending', 'subscribed', 'unsubscribed'])->default('none');
            $table->string('subscription_key')->nullable();
        });
        Provider::all()->each(function ($provider) {
            $provider->subscription_key = base64_encode(Hash::make(str_random(64)));
            $provider->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn('subscription_status');
            $table->dropColumn('subscription_key');
        });
    }
}
