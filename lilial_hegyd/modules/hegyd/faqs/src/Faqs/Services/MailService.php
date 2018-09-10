<?php
namespace Hegyd\Faqs\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;


class MailService
{
    public function sendReport($report, $datas)
    {
        $reason = (isset($datas['name']) ? $datas['name'] : '');
        $details = (isset($datas['content']) ? $datas['content'] : '');

        $author = $report->comment->author;
        $email = $author->email;

        if(!$email && $email != '')
            return;

        try
        {
            Mail::send('hegyd-faqs::emails.report', [
                'report' => $report,
                'reason' => $reason,
                'details'=> $details,
            ], function ($message) use ($email, $reason, $details) {
                $message->subject(trans('hegyd-faqs::emails.report.user.subject', ['reason' => $reason]))
                    ->to($email);
            });

        } catch (\Exception $e)
        {
            \Log::error($e);
        }
    }

    public function sendReportToAdmin($report, $datas)
    {
        $reason = (isset($datas['name']) ? $datas['name'] : '');
        $details = (isset($datas['content']) ? $datas['content'] : '');
        
        $emails = app(config('hegyd-faqs.repository.users'))->getAdminUsers()->pluck('email');

        if ( ! count($emails))
            return;

        foreach($emails as $email) {
            try
            {
                Mail::send('hegyd-faqs::emails.report_to_admin', [
                    'reason' => $reason,
                    'details'=> $details,
                    'report'=> $report
                ], function ($message) use ($email, $reason, $details, $report) {
                    $message->subject(trans('hegyd-faqs::emails.report.admin.subject', ['reason' => $reason]))
                        ->to($email);
                });

            } catch (\Exception $e)
            {
                \Log::error($e);
            }
        }
    }

//    public function sendReport($report, $datas)
//    {
//        $emails = app(config('hegyd-faqs.repository.users'))->getAdminUsers()->pluck('email');
//
//        if ( ! count($emails))
//            return;
//
//        $reason = (isset($datas['name']) ? isset($datas['name']) : '');
//        $details = (isset($datas['content']) ? isset($datas['content']) : '');
//
//        foreach ($emails as $email)
//        {
//            try
//            {
//                Mail::send('hegyd-faqs::emails.report', [
//                    'report' => $report,
//                    'reason' => $reason,
//                    'details'=> $details,
//                ], function ($message) use ($email) {
//                    $message->subject(trans('hegyd-faqs::emails.report.subject'))
//                        ->to($email);
//                });
//
//            } catch (\Exception $e)
//            {
//                \Log::error($e);
//            }
//        }
//    }

}