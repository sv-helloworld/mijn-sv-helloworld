<?php

namespace App\Http\Controllers;

use App\Activity;
use App\ActivityEntry;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resources for administrators.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        $activities = Activity::paginate(10);

        return view('activity.manage', compact('activities'));
    }

    /**
     * Display a specified listing of the resources for administrators.
     *
     * @param int $id The id of the activity
     * @return \Illuminate\Http\Response
     */
    public function entries($id)
    {
        $activity = Activity::findOrFail($id);
        $activity_entries = ActivityEntry::where('activity_id', $id)->paginate(10);

        return view('activity.entries', compact('activity', 'activity_entries'));
    }
}
