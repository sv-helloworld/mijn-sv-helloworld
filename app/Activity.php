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
        'apply_after',
        'apply_before',
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
        'apply_after',
        'apply_before',
        'starts_at',
        'ends_at',
    ];

    /**
     * Gets the prices that belong to the activity
     */
    public function prices()
    {
        return $this->hasMany('App\ActivityPrice');
    }
}
