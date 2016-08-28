<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use FormBuilder;
use App\Contribution;
use App\Subscription;
use App\Http\Requests;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $subscriptions = $user->subscriptions;
        $contribution = Contribution::where([
            'user_category_alias' => $user->user_category_alias,
        ])->first();

        return view('subscription.index', compact('subscriptions', 'contribution'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function create($slug = null)
    {
        if (is_null($slug)) {
            return redirect(route('subscription.index'));
        }

        $user = Auth::user();

        $contribution = Contribution::where([
            'user_category_alias' => $user->user_category_alias,
        ])->whereHas('period', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->first();

        if (! $contribution) {
            return redirect(route('subscription.index'));
        }

        return view('subscription.create', compact('user', 'contribution'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        $messages = [
            'accept.required' => 'Je dient akkoord te gaan met de voorwaarden.',
        ];

        $this->validate($request, [
            'accept' => 'required|boolean',
        ], $messages);

        // Retrieve the contribution
        $contribution = Contribution::where([
            'user_category_alias' => Auth::user()->user_category_alias,
        ])->whereHas('period', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->first();

        if (! $contribution) {
            return redirect(route('subscription.index'));
        }

        // Check if there is already an subscription
        $subscription = Subscription::where([
            'user_id' => Auth::user()->id,
            'contribution_id' => $contribution->id,
        ])->get();

        if (! $subscription->isEmpty()) {
            flash(sprintf('Inschrijving voor periode %s is niet gelukt omdat je al bent ingeschreven.', $contribution->period->name), 'danger');

            return redirect(route('subscription.show', $subscription->id));
        }

        // Check succesful, add new subscription
        $subscription = Subscription::create([
            'user_id' => Auth::user()->id,
            'contribution_id' => $contribution->id,
        ]);

        // Check if the subscription is created
        if (! $subscription) {
            flash(sprintf('Inschrijving voor periode %s is niet gelukt. Probeer het alstublieft opnieuw.', $contribution->period->name), 'danger');

            return back()->withInput();
        }

        flash(sprintf('Je hebt je succesvol ingeschreven als lid voor de periode %s. Binnen enkele ogenblikken zal het mogelijk zijn om je contributie te betalen. Je ontvangt ook per mail een link om de betaling te voldoen.', $contribution->period->name), 'success');

        return redirect(route('subscription.show', $subscription->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subscription = Subscription::find($id);

        if (! $subscription) {
            abort(404);
        }

        return view('subscription.show', compact('subscription'));
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
