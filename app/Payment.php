<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    const STATUS_OPEN = 'open';
    const STATUS_PAID = 'paid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_id',
        'amount',
        'description',
        'status',
        'user_id',
        'payable_id',
        'payable_type',
        'paid_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'paid_at',
    ];

    /**
     * Constructor.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        if (! isset($attributes['status'])) {
            $attributes['status'] = self::STATUS_OPEN;
        }

        parent::__construct($attributes);
    }

    /**
     * Returns the user associated with the payment.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Returns the refund associated with the payment.
     */
    public function refund()
    {
        return $this->hasOne('App\Refund');
    }

    /**
     * Returns true if the payment is paid.
     *
     * @return bool True if the payment is paid.
     */
    public function paid()
    {
        return $this->status == self::STATUS_PAID;
    }

    /**
     * Get all of the owning payable models.
     */
    public function payable()
    {
        return $this->morphTo();
    }
}
