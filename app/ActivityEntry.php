<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityEntry extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id',
      'activity_id',
      'amount',
      'notes',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'confirmed_at',
    ];

    /**
     * Get the user that applied for the activity.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Returns the activity the entry belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }

    /**
     * Get all of the subscriptions payments.
     */
    public function payments()
    {
        return $this->morphMany('App\Payment', 'payable');
    }
}
