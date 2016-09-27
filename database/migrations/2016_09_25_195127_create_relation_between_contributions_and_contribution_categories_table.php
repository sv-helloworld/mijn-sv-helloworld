<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationBetweenContributionsAndContributionCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Artisan::call('db:seed', ['--class' => 'ContributionCategoriesSeeder']);

        Schema::table('contributions', function (Blueprint $table) {
            $table->foreign('contribution_category_alias')->references('alias')->on('contribution_categories');
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
            $table->dropForeign(['contribution_category_alias']);
        });
    }
}
