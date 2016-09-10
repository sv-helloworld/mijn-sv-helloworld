<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRefundsInPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropUnique('payments_refund_id_unique');
            $table->integer('refund_id')->unsigned()->change();
            $table->dropColumn('refund_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('refund_id')->unique()->change();
            $table->decimal('refund_amount', 8, 2)->nullable();
        });
    }
}
