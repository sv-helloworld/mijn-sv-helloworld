<?php

namespace App\Http\Controllers\Auth;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use Jrean\UserVerification\Exceptions\UserNotFoundException;
use Jrean\UserVerification\Exceptions\TokenMismatchException;
use Jrean\UserVerification\Exceptions\UserIsVerifiedException;

class ActivationController extends Controller
{
    use VerifiesUsers;

    /**
     * Where to redirect if the authenticated user is already verified.
     *
     * @var string
     */
    protected $redirectIfVerified = '/account/activeren';

    /**
     * Where to redirect after a successful verification token generation.
     *
     * @var string
     */
    protected $redirectAfterTokenGeneration = '/account/activeren';

    /**
     * Where to redirect after a successful verification.
     *
     * @var string
     */
    protected $redirectAfterVerification = '/account/activeren';

    /**
     * Where to redirect after a failing token verification.
     *
     * @var string
     */
    protected $redirectIfVerificationFails = '/account/activeren/error';

    /**
     * Name of the view returned by the getVerificationError method.
     *
     * @var string
     */
    protected $verificationErrorView = 'account.activate.error';

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

        return view('account.activate.index');
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
            flash('Je account is geactiveerd.', 'success');
            UserVerification::process($request->input('email'), $token, $this->userTable());
        } catch (UserNotFoundException $e) {
            flash('Het account kon niet worden geactiveerd omdat het niet werd gevonden.', 'error');

            return redirect($this->redirectIfVerificationFails());
        } catch (UserIsVerifiedException $e) {
            flash('Het account is al geactiveerd.', 'warning');

            return redirect($this->redirectIfVerified());
        } catch (TokenMismatchException $e) {
            flash('Het account kon niet worden geactiveerd.', 'error');

            return redirect($this->redirectIfVerificationFails());
        }

        return redirect($this->redirectAfterVerification());
    }
}
