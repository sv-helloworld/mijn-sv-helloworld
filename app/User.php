<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'account_type',
        'user_category_alias',
        'contribution_category_alias',
        'activated',
        'verified',
        'first_name',
        'name_prefix',
        'last_name',
        'address',
        'zip_code',
        'city',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
        'mollie_customer_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * Get the full name of the user.
     *
     * @return string The full name of the user.
     */
    public function full_name()
    {
        return $this->first_name.($this->name_prefix ? ' '.$this->name_prefix : '').' '.$this->last_name;
    }

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
     * Checks if the user has the given user category.
     *
     * @param $user_category
     * @return bool
     */
    public function hasUserCategory($user_category)
    {
        return ! is_null($this->user_category_alias) && $this->user_category_alias == $user_category;
    }

    /**
     * Returns the user category associated with the user.
     */
    public function user_category()
    {
        return $this->hasOne('App\UserCategory', 'alias', 'user_category_alias');
    }

    /**
     * Returns the contribution category associated with the user.
     */
    public function contribution_category()
    {
        return $this->hasOne('App\ContributionCategory', 'alias', 'contribution_category_alias');
    }

    /**
     * Get the subscriptions of the user.
     */
    public function subscriptions()
    {
        return $this->hasMany('App\Subscription');
    }

    /**
     * Get the payments of the user.
     */
    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    /**
     * Get the refunds of the user.
     */
    public function refunds()
    {
        return $this->hasMany('App\Refund');
    }

    /**
     * Get the activity entries of the user.
     */
    public function activity_entries()
    {
        return $this->hasMany('App\ActivityEntry');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
