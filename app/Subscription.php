<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'contribution_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'canceled_at',
        'approved_at',
        'declined_at',
        'confirmed_at',
    ];

    /**
     * Get the user that owns the subscription.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the contribution that belongs to the subscription.
     */
    public function contribution()
    {
        return $this->belongsTo('App\Contribution');
    }

    /**
     * Returns true if the subscription is canceled.
     *
     * @return bool True if the subscription is canceled.
     */
    public function canceled()
    {
        return ! is_null($this->canceled_at);
    }

    /**
     * Returns true if the subscription is approved.
     *
     * @return bool True if the subscription is approved.
     */
    public function approved()
    {
        return ! is_null($this->approved_at);
    }

    /**
     * Returns true if the subscription is declined.
     *
     * @return bool True if the subscription is declined.
     */
    public function declined()
    {
        return ! is_null($this->declined_at);
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
     * Returns true if the subscription is valid.
     *
     * @return bool True if the subscription is valid.
     */
    public function valid()
    {
        $now = new \DateTime();
        $start_date = $this->contribution->period->start_date;
        $end_date = $this->contribution->period->end_date;

        return $now >= $start_date && $now < $end_date && $this->confirmed();
    }

    /**
     * Get all of the subscriptions payments.
     */
    public function payments()
    {
        return $this->morphMany('App\Payment', 'payable');
    }
}
