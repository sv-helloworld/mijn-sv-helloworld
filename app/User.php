<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'account_type', 'user_category', 'activated', 'verified', 'first_name', 'name_prefix', 'last_name', 'address', 'zip_code', 'city', 'phone_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_token', 'mollie_customer_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Checks if the user has the given account type.
     *
     * @param $account_type
     * @return bool
     */
    public function hasAccountType($account_type)
    {
        return ! is_null($this->account_type) && $this->account_type == $account_type;
    }

    /**
     * Returns the user category associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user_category()
    {
        return $this->hasOne('App\UserCategory', 'alias', 'user_category');
    }

    /**
     * Checks if the user has the given user category.
     *
     * @param $user_category
     * @return bool
     */
    public function hasUserCategory($user_category)
    {
        return ! is_null($this->user_category) && $this->user_category->alias == $user_category;
    }
}
