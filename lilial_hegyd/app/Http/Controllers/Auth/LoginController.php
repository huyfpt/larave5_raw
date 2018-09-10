<?php

namespace App\Http\Controllers\Auth;

use App\Events\Logs\Auth\LogoutEvent;
use App\Events\Logs\Auth\LoginEvent;
use App\Http\Controllers\Controller;
use App\Services\Common\ExtranetService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Common\User;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        $this->guard()->logout();

        $request->session()->flush();
        $request->session()->regenerate();

        if ($user)
        {
            event(new LogoutEvent($user, $user));
        }

        return redirect('/connexion');
    }

    protected function authenticated(Request $request, $user)
    {
        if ( ! $user->active)
        {
            auth()->logout();

            return $this->sendFailedLoginResponse($request);
        }

        if($user->role_id == User::ROLE_CLIENT)
        {
            return redirect('/');
        }
        else
        {
            /**
             * Share user vars
             */
            app(ExtranetService::class)->shareUserVars();
            event(new LoginEvent($user, $user));
        }

    }
}
