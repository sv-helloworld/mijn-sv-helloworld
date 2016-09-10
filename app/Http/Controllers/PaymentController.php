<?php

namespace App\Http\Controllers;

use Auth;
use Mollie;
use Gate;
use App\Payment;
use Illuminate\Http\Request;
use App\Events\PaymentCompleted;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $open_payments = Payment::where('user_id', $user->id)->whereNull('paid_at')->get();
        $finalized_payments = Payment::where('user_id', $user->id)->whereNotNull('paid_at')->get();

        return view('payment.index', compact('open_payments', 'finalized_payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $payment = Payment::findOrFail($id);

        if (! Gate::forUser($user)->allows('pay', $payment)) {
            return abort(403);
        }

        return view('payment.show', compact('payment'));
    }

    /**
     * Pay the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pay($id)
    {
        $user = Auth::user();
        $payment = Payment::findOrFail($id);

        if (! Gate::forUser($user)->allows('pay', $payment)) {
            return abort(403);
        }

        $metadata = [
            'payment_id' => $payment->id,
            'user_id' => $payment->user_id,
            'payable_id' => $payment->payable_id,
        ];

        $mollie_payment = Mollie::api()->payments()->create([
            'amount'      => $payment->amount,
            'description' => $payment->description,
            'redirectUrl' => route('payment.webhook', $payment->id),
            'metadata' => $metadata,
        ]);

        $payment->update(['payment_id' => $mollie_payment->id]);

        return redirect($mollie_payment->getPaymentUrl());
    }

    /**
     * Payment webhook.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function webhook($id)
    {
        $user = Auth::user();
        $payment = Payment::findOrFail($id);

        if (! Gate::forUser($user)->allows('pay', $payment)) {
            return abort(403);
        }

        if ($payment->paid()) {
            flash('Deze betaling is al afgerond.', 'info');

            return redirect(route('payment.show', $payment->id));
        }

        $mollie_payment = Mollie::api()->payments()->get($payment->payment_id);

        if ($mollie_payment->isPaid()) {
            $payment->update([
                'status' => $mollie_payment->status,
                'paid_at' => strtotime($mollie_payment->paidDatetime),
            ]);

            event(new PaymentCompleted($payment));
            flash('Betaling succesvol!', 'success');

            return redirect(route('payment.show', $payment->id));
        }

        flash('De betaling is mislukt, probeer het opnieuw of neem contact met ons op als het probleem aanhoud.', 'danger');

        return redirect(route('payment.show', $payment->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
