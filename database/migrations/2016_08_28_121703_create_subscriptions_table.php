<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('contribution_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('canceled')->default(false);
            $table->timestamp('canceled_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('contribution_id')->references('id')->on('contributions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('subscriptions');
    }
}
