<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Contribution;
use App\Subscription;

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

        // Retrieve the contribution
        $contributions = $this->availableContributionsForUser($user);
        $contribution = $contributions->whereHas('period', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->first();

        if (! $contribution) {
            return abort(404);
        }

        // Check if there is already an subscription
        $subscription = Subscription::where([
            'user_id' => $user->id,
            'contribution_id' => $contribution->id,
        ])->get();

        if (! $subscription->isEmpty()) {
            flash(sprintf('Je bent al ingeschreven!', $contribution->period->name), 'info');

            return redirect(route('subscription.show', $subscription->first()->id));
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

        // Retrieve the contribution
        $contributions = $this->availableContributionsForUser($user);
        $contribution = $contributions->whereHas('period', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->first();

        if (! $contribution) {
            return abort(404);
        }

        // Check if there is already an subscription
        $subscription = Subscription::where([
            'user_id' => $user->id,
            'contribution_id' => $contribution->id,
        ])->get();

        if (! $subscription->isEmpty()) {
            flash(sprintf('Inschrijving voor periode %s is niet gelukt omdat je al bent ingeschreven.', $contribution->period->name), 'danger');

            return redirect(route('subscription.show', $subscription->first()->id));
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

        flash(sprintf('Je hebt je succesvol ingeschreven als lid voor de periode %s. De mogelijkheid om de contributie te betalen verschijnt binnenkort.', $contribution->period->name), 'success');

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
        $subscriptions = Subscription::whereNull('approved_at')->whereNull('declined_at')->get();

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
            foreach ($user->subscriptions as $subscription) {
                $periods[] = $subscription->contribution->period->id;
            }
        }

        $contributions = Contribution::where([
            'user_category_alias' => $user->user_category_alias,
            ['available_from', '>=', time()],
            ['available_to', '>', time()],
        ])->whereHas('period', function ($query) use ($periods) {
            $query->whereNotIn('id', $periods);
        })->orderBy('available_from', 'asc');

        return $contributions;
    }
}
