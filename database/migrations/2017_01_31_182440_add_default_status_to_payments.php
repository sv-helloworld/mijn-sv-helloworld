<?php

use App\Payment;
use Illuminate\Database\Migrations\Migration;

class AddDefaultStatusToPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Payment::where('status', '=', '')->orWhereNull('status')->get()->each(function ($payment) {
            $payment->status = Payment::STATUS_OPEN;
            $payment->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Payment::where('status', '=', Payment::STATUS_OPEN)->get()->each(function ($payment) {
            $payment->status = null;
            $payment->save();
        });
    }
}
