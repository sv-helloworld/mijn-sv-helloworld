<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserCategoryAliasInContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->renameColumn('user_category_alias', 'contribution_category_alias');
        });

        Artisan::call('db:seed', ['--class' => 'ContributionCategoriesSeeder']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->renameColumn('contribution_category_alias', 'user_category_alias');
        });
    }
}
