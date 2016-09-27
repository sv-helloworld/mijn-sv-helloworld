<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_prices', function (Blueprint $table) {
            $table->increments('id');

            // General
            $table->integer('activity_id')->unsigned();
            $table->string('user_category_alias');
            $table->decimal('amount', 6, 2);

            // Foreign keys
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->foreign('user_category_alias')->references('alias')->on('user_categories');

            // Properties
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_prices');
    }
}
