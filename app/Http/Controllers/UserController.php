<?php

namespace App\Http\Controllers;

use App\User;
use App\UserCategory;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Validator;
use Auth;
use UserVerification;

class UserController extends Controller
{
    use ResetsPasswords;

    /**
     * Use the password broker settings for new users.
     *
     * @var string
     */
    protected $broker = 'new_users';

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * The password set view.
     *
     * @var string
     */
    protected $resetView = 'account.password.set';

    /**
     * Set the email subject.
     *
     * @var string
     */
    protected $subject = 'Uw registratie link';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::paginate(15);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user_categories = UserCategory::all();

        $user_categories_values = [];
        foreach ($user_categories as $user_category) {
            $user_categories_values[$user_category->alias] = $user_category->title;
        }

        return view('user.create', compact('user_categories_values'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'user_category' => $request->get('user_category') ? $request->get('user_category') : null,
        ]);

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users|email',
            'address' => 'required',
            'zip_code' => 'required',
            'city' => 'required',
            'account_type' => 'required',
            'activated' => 'required|boolean',
        ]);

        User::create($request->all());

        // Send password reset link to the user
        $this->sendResetLinkEmail($request);

        Flash::success('Gebruiker toegevoegd!');

        return redirect(route('user.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user_categories = UserCategory::all();

        $user_categories_values = [];
        foreach ($user_categories as $user_category) {
            $user_categories_values[$user_category->alias] = $user_category->title;
        }

        return view('user.edit', compact('user', 'user_categories_values'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $user = Auth::user();

        $request->merge([
            'user_category' => $request->get('user_category') ? $request->get('user_category') : null,
        ]);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'zip_code' => 'required',
            'city' => 'required',
            'account_type' => 'required',
            'activated' => 'required|boolean',
        ]);

        // Extra checks if the user edits his own account
        if ($id == $user->id) {
            $validator->after(function ($validator) use ($request, $user) {
                // Check if the user wants to deactivate his own account
                if (! $request->get('activated')) {
                    $validator->errors()->add('activated', 'het is niet toegestaan jezelf te deactiveren.');
                    $request->merge(['activated' => $user->activated]);
                }

                // Check if the user wants to change his own role
                if ($request->get('user_role') != $user->user_role) {
                    $validator->errors()->add('account_type', 'het is niet toegestaan om je eigen rol te wijzigen.');
                    $request->merge(['account_type' => $user->user_role]);
                }
            });
        }

        if ($validator->fails()) {
            return redirect(route('user.edit', $user->id))
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::findOrFail($id);
        $user_old_email = $user->email;
        $user->update($request->all());

        // Send email verification link when the email address has been changed
        if ($user_old_email != $request->get('email')) {
            UserVerification::generate($user);
            UserVerification::send($user, 'Verifieer uw e-mailadres');
        }

        Flash::success('Gebruiker bijgewerkt.');

        return redirect(route('user.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @param Request $request
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        $user = $request->user();

        // Check if the user wants to delete his own account
        if ($id == $user->id) {
            Flash::error('Het is niet toegestaan jezelf te verwijderen.');

            return redirect(route('user.index'));
        }

        User::destroy($id);

        Flash::success('Gebruiker verwijderd!');

        return redirect(route('user.index'));
    }

    /**
     * Activate or deactivate the given user.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function activate($id, Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'activated' => 'boolean',
        ]);

        // Validate current password
        $validator->after(function ($validator) use ($id, $user) {
            if ($id == $user->id) {
                $validator->errors()->add('activated', 'het is niet toegestaan jezelf te activeren of deactiveren.');
            }
        });

        if ($validator->fails()) {
            return redirect('user')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::findOrFail($id);
        $user->update($request->only('activated'));

        $activated = $request->get('activated');
        if ($activated) {
            Flash::success('Gebruiker geactiveerd.');
        } else {
            Flash::success('Gebruiker gedeactiveerd.');
        }

        return redirect(route('user.index'));
    }
}
