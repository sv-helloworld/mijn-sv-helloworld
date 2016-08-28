<?php

namespace App\Http\Controllers;

use App\Contribution;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContributionController extends Controller
{
    /**
     * Returns the index view.
     *
     * @return mixed The index view
     */
    public function index()
    {
        $user = Auth::user();
        $contributions = Contribution::where('user_category_alias', $user->user_category_alias)->orWhereHas('payments', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->paginate(15);

        return view('contribution.index', compact('contributions'));
    }

     /**
      * Handles the payment.
      *
      * @param  Request $request
      * @return mixed The payment view
      */
    public function pay(Request $request)
    {
        $user = Auth::user();
        $contribution = Contribution::where('user_category_alias', $user->user_category_alias)->find($request->id);

        $payment = Mollie::api()->payments()->create([
            "amount"      => $contribution->amount,
            "description" => "Betaling voor " . $contribution->period->name,
            "redirectUrl" => "",
        ]);
    }
}
