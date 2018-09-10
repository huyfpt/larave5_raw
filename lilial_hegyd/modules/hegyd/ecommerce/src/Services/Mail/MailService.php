<?php namespace Hegyd\eCommerce\Services\Mail;


class MailService
{

    protected function sendMail($to, $subject, $datas)
    {
        Mail::send('emails.orders.created.user', $datas,
            function ($message) use ($datas, $user, $site_name)
            {
                $subject = trans('emails.global.prefix_subject') . ' ';
                $subject .= trans('emails.orders.created.user.subject', ['site_name' => $site_name]);
                $message->to($user->email)->subject($subject);
            }
        );
    }

    protected function send($template, $to, $subject, $datas)
    {
        $mail = $this->prepare($template, $to, $subject, $datas);
        $mail->send();
    }

    protected function prepare($template, $to, $subject, $datas)
    {
        //$message = new Mail
    }
}