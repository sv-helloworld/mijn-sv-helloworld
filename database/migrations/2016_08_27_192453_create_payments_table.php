<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            // Fields
            $table->increments('id');
            $table->string('payment_id')->unique();
            $table->decimal('payment_amount', 8, 2)->nullable();
            $table->string('status');
            $table->string('refund_id')->unique();
            $table->decimal('refund_amount', 8, 2)->nullable();

            // User
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            // Payable
            $table->integer('payable_id')->nullable();
            $table->string('payable_type')->nullable();

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
        Schema::drop('payments');
    }
}
