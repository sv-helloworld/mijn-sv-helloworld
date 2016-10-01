<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'refund_id',
        'refund_amount',
        'payment_id',
        'user_id',
        'payable_id',
        'payable_type',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'refunded_at',
    ];

    /**
     * Returns the user associated with the refund.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Returns the payment associated with the refund.
     */
    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }
}
