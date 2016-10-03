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
      'activity_price_id',
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
     * Get the activity that belongs to the entry.
     */
    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }

    /**
     * Get the activity price that belongs to the entry.
     */
    public function activity_price()
    {
        return $this->belongsTo('App\ActivityPrice');
    }

    /**
     * Returns true if the subscription is confirmed.
     *
     * @return bool True if the subscription is confirmed.
     */
    public function confirmed()
    {
        return ! is_null($this->confirmed_at);
    }

    /**
     * Get all of the subscriptions payments.
     */
    public function payments()
    {
        return $this->morphMany('App\Payment', 'payable');
    }
}
