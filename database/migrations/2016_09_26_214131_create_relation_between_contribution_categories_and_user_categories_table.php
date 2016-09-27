<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationBetweenContributionCategoriesAndUserCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contribution_categories', function (Blueprint $table) {
            $table->foreign('user_category_alias')->references('alias')->on('user_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contribution_categories', function (Blueprint $table) {
            $table->dropForeign(['user_category_alias']);
        });
    }
}
