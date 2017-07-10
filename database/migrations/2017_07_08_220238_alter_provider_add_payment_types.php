<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProviderAddPaymentTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->boolean('accept_visa')->default(false);
            $table->boolean('accept_mc')->default(false);
            $table->boolean('accept_discover')->default(false);
            $table->boolean('accept_amex')->default(false);
            $table->boolean('accept_cash')->default(false);
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
            $table->dropColumn('accept_visa');
            $table->dropColumn('accept_mc');
            $table->dropColumn('accept_discover');
            $table->dropColumn('accept_amex');
            $table->dropColumn('accept_cash');
        });
    }
}
