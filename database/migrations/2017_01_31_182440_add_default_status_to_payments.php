<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Payment;

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
