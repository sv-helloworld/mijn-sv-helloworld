<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jrean\UserVerification\Exceptions\TokenMismatchException;
use Jrean\UserVerification\Exceptions\UserIsVerifiedException;
use Jrean\UserVerification\Exceptions\UserNotFoundException;
use Jrean\UserVerification\Facades\UserVerification;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Laracasts\Flash\Flash;

class EmailController extends Controller
{
    use VerifiesUsers;

    /**
     * Where to redirect if the authenticated user is already verified.
     *
     * @var string
     */
    protected $redirectIfVerified = '/account/email/verifieren';

    /**
     * Where to redirect after a successful verification token generation.
     *
     * @var string
     */
    protected $redirectAfterTokenGeneration = '/account/email/verifieren';

    /**
     * Where to redirect after a successful verification.
     *
     * @var string
     */
    protected $redirectAfterVerification = '/account/email/verifieren';

    /**
     * Where to redirect after a failing token verification.
     *
     * @var string
     */
    protected $redirectIfVerificationFails = '/account/email/verifieren/error';

    /**
     * Name of the view returned by the getVerificationError method.
     *
     * @var string
     */
    protected $verificationErrorView = 'account.email.verificate.error';

    /**
     * Email verificate index view.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (! $request->session()->has('flash_notification.message')) {
            return redirect('account');
        }

        return view('account.email.verificate.index');
    }

    /**
     * Email edit view.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        return view('account.email.edit');
    }

    /**
     * Updates the users' email address.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@hz.nl$/|max:255|unique:users|confirmed',
        ]);

        $user = Auth::user();
        $user->update($request->only('email'));

        // Send email verification link
        UserVerification::generate($user);
        UserVerification::send($user, 'Verifieer je e-mailadres');

        Flash::success('Je e-mailadres is bijgewerkt. Er is een e-mail gestuurd met een link om je e-mailadres te valideren.');

        return redirect('account');
    }

    /**
     * Handle the user verification.
     *
     * @param Request $request
     * @param  string $token
     * @return Response
     */
    public function getVerification(Request $request, $token)
    {
        $this->validateRequest($request);

        try {
            Flash::success('Je e-mailadres is geverifieerd.');
            UserVerification::process($request->input('email'), $token, $this->userTable());
        } catch (UserNotFoundException $e) {
            Flash::error('Het e-mailadres kon niet worden geverifieerd omdat de gebruiker niet werd gevonden.');

            return redirect($this->redirectIfVerificationFails());
        } catch (UserIsVerifiedException $e) {
            Flash::warning('Het e-mailadres is al geverifieerd.');

            return redirect($this->redirectIfVerified());
        } catch (TokenMismatchException $e) {
            Flash:error('Het e-mailadres kon niet worden geverifieerd.');

            return redirect($this->redirectIfVerificationFails());
        }

        return redirect($this->redirectAfterVerification());
    }
}
