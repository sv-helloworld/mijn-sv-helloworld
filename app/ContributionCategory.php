<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContributionCategory extends Model
{
    /**
     * The primary key to use for this model.
     *
     * @var string
     */
    public $primaryKey = 'alias';

    /**
     * Set whether the primary key is incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contribution_categories';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'alias',
        'user_category_alias',
    ];
}
