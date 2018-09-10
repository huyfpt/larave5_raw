<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Common\UserRepositoryInterface;
use App\Services\Mail\UserService;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['username' => 'required']);

        $user = app(UserRepositoryInterface::class)->findByUsername($request->get('username'));

        if ( ! $user)
        {
            return redirect()->back()->withErrors(['username' => trans('auth.failed')]);
        } elseif ( ! $user->active)
        {
            return redirect()->back()->withErrors(['username' => trans('auth.users.not_active')]);
        }


        // Once we have the reset token, we are ready to send the message out to this
        // user with a link to reset their password. We will then redirect back to
        // the current URI having nothing set in the session to indicate errors.
        $token = $this->broker()->createToken($user);

        app(UserService::class)->sendResetPasswordRequest($user, $token);

        return redirect()->back()->with(['status' => trans(Password::RESET_LINK_SENT)]);
    }
}
