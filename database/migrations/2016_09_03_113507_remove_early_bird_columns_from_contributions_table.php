<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveEarlyBirdColumnsFromContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->dropColumn('early_bird_amount');
            $table->dropColumn('early_bird_end_date');
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
            $table->decimal('early_bird_amount', 6, 2);
            $table->date('early_bird_end_date');
        });
    }
}
