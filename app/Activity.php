<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'available_from',
        'available_to',
        'starts_at',
        'ends_at',
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
        'starts_at',
        'ends_at',
    ];

    /**
     * Gets the prices that belong to the activity.
     */
    public function prices()
    {
        return $this->hasMany('App\ActivityPrice');
    }

    /**
     * Gets the entries that belong to the activity.
     */
    public function entries()
    {
        return $this->hasMany('App\ActivityEntry');
    }
}
