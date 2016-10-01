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
        'amount',
        'available_from',
        'available_to',
        'contribution_category_alias',
        'period_id',
        'is_early_bird',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'available_from',
        'available_to',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_early_bird' => 'boolean',
    ];

    /**
     * Returns the contribution category associated with the contribution.
     */
    public function contribution_category()
    {
        return $this->hasOne('App\ContributionCategory', 'alias', 'contribution_category_alias');
    }

    /**
     * Returns the period of the contribution.
     */
    public function period()
    {
        return $this->belongsTo('App\Period');
    }
}
