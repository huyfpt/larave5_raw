<?php namespace App\Services\Mail;

use App\Facades\Front;
use App\Facades\RoutesTools;
use App\Facades\Tools;
use App\Models\Common\SignOnRequest;
use App\Models\Common\User;
use Illuminate\Support\Facades\Mail;

class UserService
{

    /**
     * Send the mail to the user for resetting the password
     * @param User $user
     */
    public function sendResetPasswordRequest(User $user, $token, $callback = null)
    {
        if ( ! $this->canSendEmail($user))
            return;

        $site_domain = env('APP_URL');
        $site_name = env('APP_NAME');
        $title = trans('emails.users.reset_password.subject');

        Mail::send('emails.users.reset_password', compact('token', 'user', 'site_domain', 'site_name', 'title'), function ($m) use ($user, $token, $callback)
        {

            $subject = trans('emails.global.prefix_subject') . ' ';
            $subject .= trans('emails.users.reset_password.subject');

            $m->subject($subject)
                ->to($user->getEmailForPasswordReset());

            if ( ! is_null($callback))
            {
                call_user_func($callback, $m, $user, $token);
            }
        });
    }

    public function sendForceResetPassword(User $user, $password)
    {
        if ( ! $this->canSendEmail($user))
            return;

        $site_domain = env('APP_URL');
        $site_name = env('APP_NAME');

        Mail::send('emails.users.force_reset_password', compact('password', 'user', 'site_domain', 'site_name'), function ($m) use ($user, $password)
        {

            $subject = trans('emails.global.prefix_subject') . ' ';
            $subject .= trans('emails.users.force_reset_password.subject');

            $m->subject($subject)
                ->to($user->getEmailForPasswordReset());
        });
    }

    private function canSendEmail(User $user)
    {
        if (is_null($user) || !$user->getEmailForPasswordReset())
        {
            return false;
        }

        return true;
    }
}