<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use Mollie;
use App\User;
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

        if (! $user->can('view', $payment)) {
            return abort(403);
        }

        return view('payment.show', compact('payment'));
    }

    /**
     * Get an invoice of the payment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoice($id)
    {
        $user = Auth::user();
        $payment = Payment::findOrFail($id);

        if (! $user->can('view', $payment)) {
            return abort(403);
        }

        if (! $payment->paid()) {
            return abort(404);
        }

        $pdf = PDF::loadView('payment.invoice', compact('payment'));

        return $pdf->download(sprintf('factuur_%s.pdf', $payment->id));
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

        if (! $user->can('pay', $payment)) {
            return abort(403);
        }

        $metadata = [
            'payment_id' => $payment->id,
            'user_id' => $payment->user_id,
            'payable_id' => $payment->payable_id,
        ];

        $mollie_payment = Mollie::api()->payments()->create([
            'amount' => $payment->amount,
            'description' => sprintf('Nr: %d - %s', $payment->id, $payment->description),
            'redirectUrl' => route('payment.callback', $payment->id),
            'metadata' => $metadata,
        ]);

        $payment->update(['payment_id' => $mollie_payment->id]);

        return redirect($mollie_payment->getPaymentUrl());
    }

    /**
     * Payment webhook.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function webhook(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $mollie_payment = Mollie::api()->payments()->get($request->input('id'));

        if ($mollie_payment->isPaid()) {
            $payment = Payment::findOrFail($mollie_payment->metadata->payment_id);
            $payment->update([
                'status' => Payment::STATUS_PAID,
                'paid_at' => strtotime($mollie_payment->paidDatetime),
            ]);

            event(new PaymentCompleted($payment));
        }
    }

    /**
     * Display the specified resource with callback messages.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function callback($id)
    {
        $user = Auth::user();
        $payment = Payment::findOrFail($id);

        if (! $user->can('pay', $payment)) {
            return abort(403);
        }

        $mollie_payment = Mollie::api()->payments()->get($payment->payment_id);

        if ($mollie_payment->isPaid()) {
            $payment = Payment::findOrFail($mollie_payment->metadata->payment_id);
            $payment->update([
                'status' => Payment::STATUS_PAID,
                'paid_at' => strtotime($mollie_payment->paidDatetime),
            ]);

            flash('Bedankt! Je betaling is succesvol verwerkt.', 'success');

            return redirect(route('payment.show', $id));
        }

        flash('De betaling is mislukt, probeer het opnieuw of neem contact met ons op als het probleem aanhoudt.', 'warning');

        return redirect(route('payment.show', $id));
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

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function user(Request $request, $id)
    {
        $user = User::findOrFail($id);

        return view('payment.user', compact('user'));
    }
}
