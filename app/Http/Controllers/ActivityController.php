<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Activity;
use Carbon\Carbon;
use App\ActivityEntry;
use Illuminate\Http\Request;
use App\Events\UserAppliedForActivity;

class ActivityController extends Controller
{
    /**
     * Returns the index view.
     *
     * @return mixed The index view
     */
    public function index()
    {
        $activities = Activity::where([
            ['apply_before', '>=', Carbon::today()],
            ['apply_after', '<=', Carbon::today()],
        ])->get();

        return view('activity.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $user = Auth::user();

        if (is_null($id)) {
            return redirect(route('activity.index'));
        }

        // Get the activity information
        $activity = Activity::findOrFail($id);
        $activity_entry = ActivityEntry::where([
            ['user_id', $user->id],
            ['activity_id', $activity->id],
        ])->first();

        if ($activity_entry) {
            flash('Je kunt je niet aanmelden voor deze activiteit, mogelijk omdat je je al hebt aangemeld.', 'info');

            return redirect(route('activity.index'));
        }

        $activity_price = $activity->prices()->where('user_category_alias', $user->user_category_alias)->first();

        return view('activity.create', compact('user', 'activity', 'activity_price'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $messages = [
            'accept.required' => 'Je dient akkoord te gaan met de voorwaarden.',
        ];

        $this->validate($request, [
            'accept' => 'required|boolean',
        ], $messages);

        $user = Auth::user();

        // Get the activity information
        $activity = Activity::findOrFail($id);
        $activity_entry = ActivityEntry::where([
            ['user_id', $user->id],
            ['activity_id', $activity->id],
        ])->first();

        if ($activity_entry) {
            flash('Je kunt je niet aanmelden voor deze activiteit, mogelijk omdat je je al hebt aangemeld.', 'info');

            return redirect(route('activity.index'));
        }

        // Check succesful, add new activity entry
        $activity_price = $activity->prices()->where('user_category_alias', $user->user_category_alias)->first();
        $activity_entry = ActivityEntry::create([
            'user_id' => $user->id,
            'activity_id' => $activity->id,
            'amount' => $activity_price->amount,
        ]);

        // Check if the subscription is created
        if (! $activity_entry) {
            flash(sprintf('Aanmelden voor de activiteit \'%s\' is niet gelukt. Probeer het alstublieft opnieuw.', $activity->title), 'danger');

            return back()->withInput();
        }

        if($activity_entry->amount > 0) {
            flash(sprintf('Je hebt je succesvol aangemeld voor de activiteit \'%s\', je ontvangt binnenkort een mail met betalingsinstructies.', $activity->title), 'success');

            // Fire 'UserAppliedForActivity' event
            event(new UserAppliedForActivity($activity_entry));

            return redirect(route('activity.show', $activity->id));
        }

        flash(sprintf('Je hebt je succesvol aangemeld voor de activiteit \'%s\'.', $activity->title), 'success');

        return redirect(route('activity.show', $activity->id));
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
        $activity = Activity::findOrFail($id);
        $activity_entry = ActivityEntry::where([
            ['user_id', $user->id],
            ['activity_id', $activity->id],
        ])->first();
        $activity_price = $activity->prices()->where('user_category_alias', $user->user_category_alias)->first();

        return view('activity.show', compact('activity', 'activity_entry', 'activity_price'));
    }
}
