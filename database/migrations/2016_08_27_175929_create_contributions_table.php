<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contributions', function (Blueprint $table) {
            // Fields
            $table->increments('id');
            $table->decimal('amount', 6, 2);
            $table->decimal('early_bird_amount', 6, 2);
            $table->date('early_bird_end_date');

            // User category
            $table->string('user_category')->nullable();
            $table->foreign('user_category')->references('alias')->on('user_categories');

            // Period
            $table->integer('period')->unsigned();
            $table->foreign('period')->references('id')->on('periods');

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
        Schema::drop('contributions');
    }
}
