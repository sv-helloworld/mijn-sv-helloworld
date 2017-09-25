<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Events\UserCreatedOrChanged;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use Jrean\UserVerification\Exceptions\UserNotFoundException;
use Jrean\UserVerification\Exceptions\TokenMismatchException;
use Jrean\UserVerification\Exceptions\UserIsVerifiedException;

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
        if (! $request->session()->has('flash_notification')) {
            return redirect('account')->with('flash_notification');
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

        // Fire 'UserCreatedOrChanged' event
        event(new UserCreatedOrChanged($user));

        // Send email verification link
        UserVerification::generate($user);
        UserVerification::send($user, 'Verifieer je e-mailadres');

        flash('Je e-mailadres is bijgewerkt. Er is een e-mail gestuurd met een link om je e-mailadres te valideren.', 'success');

        return redirect('account');
    }

    /**
     * Resend the e-mail verification again.
     *
     * @param  Request $request
     * @return Response
     */
    public function resend(Request $request)
    {
        return view('account.email.verificate.resend');
    }

    /**
     * Resend the e-mail verification again.
     *
     * @param  Request $request
     * @return Response
     */
    public function resendVerification(Request $request)
    {
        $user = Auth::user();

        // Check if the e-mail is already verified
        if ($user->verified) {
            flash('Je e-mail is al geverifieerd.', 'info');

            return redirect(route('account.email.verificate.resend'));
        }

        // Check if there's a verification token set
        if (! $user->verification_token) {
            UserVerification::generate($user);
        }

        // Send email verification link
        UserVerification::send($user, 'Verifieer je e-mailadres');

        flash('Er is opnieuw een e-mail gestuurd met een link om je e-mailadres te valideren.', 'success');

        return redirect(route('account.email.verificate.resend'));
    }

    /**
     * Handle the user verification.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function getVerification(Request $request, $token)
    {
        if (! $this->validateRequest($request)) {
            return redirect($this->redirectIfVerificationFails());
        }

        try {
            $user = UserVerification::process($request->input('email'), $token, $this->userTable());

            flash('Bedankt, je e-mailadres is nu geverifieerd.', 'success');
        } catch (UserNotFoundException $e) {
            flash('Het e-mailadres kon niet worden geverifieerd omdat de gebruiker niet werd gevonden.', 'error');

            return redirect($this->redirectIfVerificationFails());
        } catch (UserIsVerifiedException $e) {
            flash('Het e-mailadres is al geverifieerd.', 'info');

            return redirect($this->redirectIfVerified());
        } catch (TokenMismatchException $e) {
            flash('Het e-mailadres kon niet worden geverifieerd.', 'danger');

            return redirect($this->redirectIfVerificationFails());
        }

        if (config('user-verification.auto-login') === true) {
            auth()->loginUsingId($user->id);
        }

        return redirect($this->redirectAfterVerification());
    }
}
