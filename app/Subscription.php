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
    protected $fillable = ['user_id', 'contribution_id', 'canceled', 'canceled_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'canceled_at'];

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
     * Get all of the contributions payments.
     */
    public function payments()
    {
        return $this->morphMany('App\Payment', 'payable');
    }
}
