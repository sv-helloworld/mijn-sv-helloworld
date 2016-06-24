<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jrean\UserVerification\Exceptions\TokenMismatchException;
use Jrean\UserVerification\Exceptions\UserIsVerifiedException;
use Jrean\UserVerification\Exceptions\UserNotFoundException;
use Jrean\UserVerification\Facades\UserVerification;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Laracasts\Flash\Flash;

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
            Flash::success('Uw account is geactiveerd.');
            UserVerification::process($request->input('email'), $token, $this->userTable());
        } catch (UserNotFoundException $e) {
            Flash::error('Het account kon niet worden geactiveerd omdat het niet werd gevonden.');

            return redirect($this->redirectIfVerificationFails());
        } catch (UserIsVerifiedException $e) {
            Flash::warning('Het account is al geactiveerd.');

            return redirect($this->redirectIfVerified());
        } catch (TokenMismatchException $e) {
            Flash:error('Het account kon niet worden geactiveerd.');

            return redirect($this->redirectIfVerificationFails());
        }

        return redirect($this->redirectAfterVerification());
    }
}
