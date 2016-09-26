<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Contribution;
use App\Subscription;
use Illuminate\Http\Request;
use App\Events\SubscriptionApproved;

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
        $contributions = $this->availableContributionsForUser($user)->get();

        return view('subscription.index', compact('subscriptions', 'contributions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function create($slug = null)
    {
        $user = Auth::user();

        if (is_null($slug)) {
            return redirect(route('subscription.index'));
        }

        // Check if there is already an subscription in the same period
        $contributions = $this->availableContributionsForUser($user);
        $contribution = $contributions->whereHas('period', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->first();

        if (! $contribution) {
            flash('Je kunt je niet inschrijven voor deze periode, mogelijk omdat je je al hebt ingeschreven.', 'info');

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

        $user = Auth::user();

        // Check if there is already an subscription in the same period
        $contributions = $this->availableContributionsForUser($user);
        $contribution = $contributions->whereHas('period', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->first();

        if (! $contribution) {
            flash(sprintf('Je kunt je niet inschrijven voor deze periode, mogelijk omdat je je al hebt ingeschreven.', $contribution->period->name), 'info');

            return redirect(route('subscription.index'));
        }

        // Check succesful, add new subscription
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'contribution_id' => $contribution->id,
        ]);

        // Check if the subscription is created
        if (! $subscription) {
            flash(sprintf('Inschrijving voor periode %s is niet gelukt. Probeer het alstublieft opnieuw.', $contribution->period->name), 'danger');

            return back()->withInput();
        }

        flash(sprintf('Je hebt je succesvol ingeschreven als lid voor de periode %s. We zullen je op de hoogte brengen wanneer je inschrijving is goedgekeurd, en je de contributie kunt betalen.', $contribution->period->name), 'success');

        return redirect(route('subscription.show', $subscription->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $subscription = Subscription::findOrFail($id);

        if (! $user->can('view', $subscription)) {
            return abort(403);
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

    /**
     * Display a listing of the resources for administrators.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        $subscriptions = Subscription::whereNull('approved_at')->whereNull('declined_at')->paginate(10);

        return view('subscription.manage', compact('subscriptions'));
    }

    /**
     * Approve the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);

        $subscription->approved_at = time();

        if ($subscription->touch()) {
            flash('De inschrijving is succesvol goedgekeurd.', 'success');

            // Fire 'SubscriptionApproved' event
            event(new SubscriptionApproved($subscription));

            return redirect(route('subscription.manage'));
        }

        flash('De inschrijving kon niet worden goedgekeurd.', 'danger');

        return redirect(route('subscription.manage'));
    }

    /**
     * Decline the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function decline(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);

        $subscription->declined_at = time();

        if ($subscription->touch()) {
            flash('De inschrijving is succesvol geweigerd.', 'success');

            return redirect(route('subscription.manage'));
        }

        flash('De inschrijving kon niet worden geweigerd.', 'danger');

        return redirect(route('subscription.manage'));
    }

    /**
     * Returns the available contributions for the given user.
     *
     * @param  User   $user
     * @param  array  $ignoreCurrentSubscriptions
     * @return array
     */
    private function availableContributionsForUser(User $user, $ignoreCurrentSubscriptions = false)
    {
        $periods = [];

        // Get periods the user is already subscribed to
        if (! $ignoreCurrentSubscriptions) {
            $periods = $user->subscriptions->map(function ($subscription) {
                return $subscription->contribution->period->id;
            })->all();
        }

        $contributions = Contribution::where('contribution_category_alias', $user->contribution_category_alias)
            ->where([
                ['available_from', '<=', date('Y-m-d H:i:s')],
                ['available_to', '>', date('Y-m-d H:i:s')],
            ])
            ->whereHas('period', function ($query) use ($periods) {
                $query->whereNotIn('id', $periods);
            })
            ->orderBy('available_from', 'asc');

        return $contributions;
    }
}
