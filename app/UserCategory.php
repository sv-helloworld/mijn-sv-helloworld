<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'alias';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_categories';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'alias',
        'mailchimp_interest_id',
    ];
}
