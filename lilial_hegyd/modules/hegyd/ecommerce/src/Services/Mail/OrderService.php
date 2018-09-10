<?php namespace Hegyd\eCommerce\Services\Mail;

use Hegyd\eCommerce\Models\eCommerce\Order;
use Illuminate\Support\Facades\Mail;

class OrderService
{

    public function orderCreated(Order $order)
    {
        $this->orderCreatedToAdmin($order);
        $this->orderCreatedToUser($order);
    }

    public function orderCreatedToAdmin(Order $order)
    {
        $adminUsers = app(config('hegyd-ecommerce.repositories.user'))->getAdminUsers();

        $order_link = route('admin::orders.edit', $order->id);

        $datas = compact('site_name', 'site_domain', 'order', 'order_link');


        foreach ($adminUsers as $user)
        {
            $datas['user'] = $user;

            if ( ! $user->email)
                continue;

            Mail::send('emails.orders.created.admin', $datas,
                function ($message) use ($datas, $user, $site_name)
                {
                    $subject = trans('emails.global.prefix_subject') . ' ';
                    $subject .= trans('emails.orders.created.admin.subject', ['site_name' => $site_name]);
                    $message->to($user->email)->subject($subject);
                }
            );
        }
    }

    public function orderCreatedToUser(Order $order)
    {
        $site = $order->site;
        $site_name = $site->name;
        $site_domain = RoutesTools::getFullDomain($site->subdomain);

        $user = $order->user;

        if ( ! $user->email)
            return;

        $order_link = '#';

        $datas = compact('site_name', 'site_domain', 'order', 'order_link', 'user');

        Mail::send('emails.orders.created.user', $datas,
            function ($message) use ($datas, $user, $site_name)
            {
                $subject = trans('emails.global.prefix_subject') . ' ';
                $subject .= trans('emails.orders.created.user.subject', ['site_name' => $site_name]);
                $message->to($user->email)->subject($subject);
            }
        );
    }

    public function orderOnGoing(Order $order)
    {

        $site = $order->site;
        $site_name = $site->name;
        $site_domain = RoutesTools::getFullDomain($site->subdomain);

        $user = $order->user;

        if ( ! $user->email)
            return;

        $order_link = '#';

        $datas = compact('site_name', 'site_domain', 'order', 'order_link', 'user');

        Mail::send('emails.orders.on_going.user', $datas,
            function ($message) use ($datas, $user, $order)
            {
                $subject = trans('emails.global.prefix_subject') . ' ';
                $subject .= trans('emails.orders.on_going.user.subject', ['order_reference' => $order->reference]);
                $message->to($user->email)->subject($subject);
            }
        );
    }

    public function orderValidated(Order $order)
    {
        $site = $order->site;
        $site_name = $site->name;
        $site_domain = RoutesTools::getFullDomain($site->subdomain);

        $user = $order->user;

        if ( ! $user->email)
            return;

        $order_link = '#';

        $datas = compact('site_name', 'site_domain', 'order', 'order_link', 'user');

        Mail::send('emails.orders.validated.user', $datas,
            function ($message) use ($datas, $user, $order)
            {
                $subject = trans('emails.global.prefix_subject') . ' ';
                $subject .= trans('emails.orders.validated.user.subject', ['order_reference' => $order->reference]);
                $message->to($user->email)->subject($subject);
            }
        );
    }
}