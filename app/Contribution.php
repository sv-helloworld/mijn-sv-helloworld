<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contribution extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'available_from', 'available_to', 'user_category_alias', 'period_id', 'is_early_bird'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'available_from', 'available_to'];

    /**
     * Returns the user category associated with the contribution.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user_category()
    {
        return $this->hasOne('App\UserCategory', 'alias', 'user_category_alias');
    }

    /**
     * Returns the period of the contribution.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function period()
    {
        return $this->belongsTo('App\Period');
    }

    /**
     * Get all of the contributions payments.
     */
    public function payments()
    {
        return $this->morphMany('App\Payment', 'payable');
    }
}
