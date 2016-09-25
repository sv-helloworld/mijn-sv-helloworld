<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContributionCategory extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'alias';

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
    ];
}
