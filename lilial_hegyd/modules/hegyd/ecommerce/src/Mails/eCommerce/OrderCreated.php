<?php namespace Hegyd\eCommerce\Mails\eCommerce;


use Hegyd\eCommerce\Mails\AbstractMail;
use Hegyd\eCommerce\Models\eCommerce\Order;
use Hegyd\eCommerce\Services\eCommerce\OrderService;
use Illuminate\Mail\Mailable;

class OrderCreated extends AbstractMail
{

    protected $user;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        parent::__constuct();
        $this->order = $order;
    }

    public function configure()
    {
        return [
            'prefixes' => [
                'lang'  => 'hegyd-ecommerce::emails.orders.created.',
                'view'  => 'hegyd-ecommerce::emails.orders.',
            ],
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->user = $this->order->user;

        if ( ! $this->user || ! $this->user->email)
            return;

        $admins = app(config('hegyd-ecommerce.repositories.user'))->getAdminUsers();

        $this->subject($this->trans('subject'));
        $this->to($this->user->email);
        $this->bcc($admins->pluck('email'));


        $this->with([
            'order' => $this->order,
            'user'  => $this->user,
        ]);

        $this->view($this->getView('created'));
        $title = trans('hegyd-ecommerce::orders.labels.invoice_name', ['reference' => $this->order->reference]);

        $invoice = app(OrderService::class)->generateInvoice($this->order);
        $this->attachData($invoice->stream(), "$title.pdf");

        return $this;
    }
}