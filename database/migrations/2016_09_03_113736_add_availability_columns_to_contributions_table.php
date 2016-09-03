<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvailabilityColumnsToContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->timestamp('available_to');
            $table->timestamp('available_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->dropColumn('available_to');
            $table->dropColumn('available_from');
        });
    }
}
