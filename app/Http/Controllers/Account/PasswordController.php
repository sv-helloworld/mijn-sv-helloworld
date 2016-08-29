<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laracasts\Flash\Flash;
use Validator;

class PasswordController extends Controller
{
    public function edit(Request $request)
    {
        return view('account.password.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'password_current' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        // Validate current password
        $validator->after(function ($validator) use ($request, $user) {
            if (! Hash::check($request->input('password_current'), $user->password)) {
                $validator->errors()->add('password_current', 'huidige wachtwoord is onjuist.');
            }
        });

        if ($validator->fails()) {
            return redirect(route('account.password.edit'))
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only(
            'password'
        );

        // Save new password
        $user->password = bcrypt($credentials['password']);
        $user->save();

        flash('Je wachtwoord is bijgewerkt.', 'success');

        return redirect('account');
    }
}
