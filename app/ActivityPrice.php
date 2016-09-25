<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user_category()
    {
        return $this->hasOne('App\UserCategory', 'alias', 'user_category_alias');
    }

    /**
     * Returns the activity the price belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activity()
    {
        return $this->hasOne('App\Activity', 'id', 'activity_id');
    }
}
