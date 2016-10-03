<?php

namespace App\Policies;

use App\User;
use App\ActivityEntry;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityEntryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the activityEntry.
     *
     * @param  App\User  $user
     * @param  App\ActivityEntry  $activity_entry
     * @return mixed
     */
    public function view(User $user, ActivityEntry $activity_entry)
    {
        return $user->id === $activity_entry->user_id;
    }

    /**
     * Determine whether the user can create activityEntries.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the activityEntry.
     *
     * @param  App\User  $user
     * @param  App\ActivityEntry  $activity_entry
     * @return mixed
     */
    public function update(User $user, ActivityEntry $activity_entry)
    {
        return $user->id === $activity_entry->user_id;
    }

    /**
     * Determine whether the user can delete the activityEntry.
     *
     * @param  App\User  $user
     * @param  App\ActivityEntry  $activity_entry
     * @return mixed
     */
    public function delete(User $user, ActivityEntry $activity_entry)
    {
        return $user->id === $activity_entry->user_id;
    }
}
