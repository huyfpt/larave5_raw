<?php namespace App\Services\Mail;

use App\Facades\Front;
use App\Facades\RoutesTools;
use App\Facades\Tools;
use App\Models\Common\User;
use Illuminate\Support\Facades\Mail;
use App\Services\Content\SettingService;

class ContactService
{
    public function sendContact($input)
    {
        $to = app(SettingService::class)->get('company.email');
        $subject = 'Contact Lilial: ' . $input["email"];
        $title   = $subject;

        if (empty($to)) {
            return false;
        }

        $body['Nom']         = $input['nom'];
        $body['Prenom']      = $input['prenom'];
        $body['Email']       = $input['email'];
        $body['Phone']       = $input['phone'];
        $body['Ville']       = $input['ville'];
        $body['Code Postal'] = $input['code_postal'];

        if (!empty($input['association'])) {
            $body['Association'] = $input['association'];
        }

        if (!empty($input['societe'])) {
            $body['Societe']     = $input['societe'];
        }

        $body['Comment']     = $input['comment'];

        Mail::send('emails.contacts.contacts', compact('body', 'title', 'subject'),

            function($e) use ($to, $subject){
                $e->subject($subject)
                        ->to($to);
            }
        );

        return true;
    }

}