<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Provider;

class AlterProvidersAddPhoneNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->string('phone_numbers');
        });

        Provider::withTrashed()->get()->each(function ($provider) {
            $provider->phone_numbers = preg_replace("/[^0-9]/", "", $provider->phone);
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
            $table->dropColumn('phone_numbers');
        });
    }
}
