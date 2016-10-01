<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationBetweenActivityEntriesAndActivityPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity_entries', function (Blueprint $table) {
            $table->foreign('activity_price_id')->references('id')->on('activity_prices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_entries', function (Blueprint $table) {
            $table->dropForeign(['activity_price_id']);
        });
    }
}
