<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class AccountController extends Controller
{
    /**
     * Account index view.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        return view('account.index', compact('user'));
    }

    /**
     * Account edit view.
     *
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request)
    {
        $user = Auth::user();

        return view('account.edit', compact('user'));
    }

    /**
     * Update account action.
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'zip_code' => 'required',
            'city' => 'required',
        ]);

        $user = Auth::user();
        $user->update($request->only('first_name', 'name_prefix', 'last_name', 'phone_number', 'address', 'zip_code', 'city'));

        Flash::success('Uw gegevens zijn bijgewerkt!');

        return redirect('account');
    }

    /**
     * Account deactivated view.
     *
     * @param Request $request
     * @return Response
     */
    public function deactivated(Request $request)
    {
        return view('account.deactivated');
    }
}
