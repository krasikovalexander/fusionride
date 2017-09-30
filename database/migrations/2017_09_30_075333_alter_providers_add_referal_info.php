<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProvidersAddReferalInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->string('referral_key')->nullable();
            $table->integer('referred_by')->unsigned()->nullable();
        });

        DB::statement("update providers set referral_key = MD5(CONCAT(id, created_at))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn('referral_key');
            $table->dropColumn('referred_by');
        });
    }
}
