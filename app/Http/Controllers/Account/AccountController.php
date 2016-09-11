<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
            'first_name' => 'required|regex:/^[a-zàâçéèêëîïôûùüÿñæœ\s-]+$/i|max:255',
            'name_prefix' => 'regex:/^[a-zàâçéèêëîïôûùüÿñæœ\s-]+$/i|max:16',
            'last_name' => 'required|regex:/^[a-zàâçéèêëîïôûùüÿñæœ\s-]+$/i|max:255',
            'phone_number' => ['regex:/(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)/'],
            'address' => ['required', 'regex:/^([1-9][e][\s])*([a-zA-Z]+(([\.][\s])|([\s]))?)+[1-9][0-9]*(([-][1-9][0-9]*)|([\s]?[a-zA-Z]+))?$/i', 'max:255'],
            'zip_code' => ['required', 'regex:/^[1-9][0-9]{3} ?(?!sa|sd|ss)[a-z]{2}$/i', 'max:7'],
            'city' => ['required', 'regex:/^([a-zA-Z\x{0080}-\x{024F}]+(?:. |-| |\'))*[a-zA-Z\x{0080}-\x{024F}]*$/u', 'max:255'],
        ]);

        $user = Auth::user();
        $user->update($request->only('first_name', 'name_prefix', 'last_name', 'phone_number', 'address', 'zip_code', 'city'));

        flash('Je gegevens zijn bijgewerkt!', 'success');

        return redirect(route('account.index'));
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
