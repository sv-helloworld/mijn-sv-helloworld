<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameUserCategoryColumnUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_category']);
            $table->renameColumn('user_category', 'user_category_alias');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_category_alias']);
            $table->renameColumn('user_category_alias', 'user_category');
            $table->foreign('user_category')->references('alias')->on('user_categories');
        });
    }
}
