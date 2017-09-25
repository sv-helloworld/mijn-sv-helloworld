<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Events\UserCreatedOrChanged;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, VerifiesUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Name of the view returned by the getVerificationError method.
     *
     * @var string
     */
    protected $verificationEmailView = 'emails.user-activation';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        $this->guard()->login($user);

        UserVerification::generate($user);
        UserVerification::send($user, 'Activeer je account');

        flash('Je account is succesvol aangemaakt! We hebben een activatielink naar je e-mailadres gestuurd. Het kan even duren voor je de activatielink ontvangt.', 'success');

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|regex:/^[a-zàâçéèêëîïôûùüÿñæœ\'\s-]+$/i|max:255',
            'name_prefix' => 'regex:/^[a-zàâçéèêëîïôûùüÿñæœ\'\s-]+$/i|max:16',
            'last_name' => 'required|regex:/^[a-zàâçéèêëîïôûùüÿñæœ\'\s-]+$/i|max:255',
            'email' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@hz.nl$/|max:255|unique:users',
            'phone_number' => ['regex:/(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)/'],
            'address' => ['required', 'regex:/^([1-9][e][\s])*([a-zA-Z]+(([\.][\s])|([\s]))?)+[1-9][0-9]*(([-][1-9][0-9]*)|([\s]?[a-zA-Z]+))?$/i', 'max:255'],
            'zip_code' => ['required', 'regex:/^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i', 'max:7'],
            'city' => ['required', 'regex:/^([a-zA-Z\x{0080}-\x{024F}]+(?:. |-| |\'))*[a-zA-Z\x{0080}-\x{024F}]*$/u', 'max:255'],
            'password' => 'required|min:8|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'name_prefix' => $data['name_prefix'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'address' => $data['address'],
            'zip_code' => $data['zip_code'],
            'city' => $data['city'],
            'password' => bcrypt($data['password']),
            'user_category_alias' => 'geen-lid',
            'contribution_category_alias' => 'lid',
        ]);

        // Fire 'UserCreatedOrChanged' event
        event(new UserCreatedOrChanged($user));

        return $user;
    }
}
