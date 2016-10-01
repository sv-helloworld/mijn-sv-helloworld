<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityPrice extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_category_alias',
      'activity_id',
      'amount',
    ];

    /**
     * Returns the user category associated with the price for the activity.
     */
    public function user_category()
    {
        return $this->hasOne('App\UserCategory', 'alias', 'user_category_alias');
    }

    /**
     * Returns the activity the price belongs to.
     */
    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }

    /**
     * Returns the activity entries the price belongs to.
     */
    public function activity_entries()
    {
        return $this->belongsToMany('App\ActivityEntry');
    }
}
