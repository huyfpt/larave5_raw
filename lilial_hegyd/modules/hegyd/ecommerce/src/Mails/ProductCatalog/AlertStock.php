<?php namespace Hegyd\eCommerce\Mails\ProductCatalog;

use Hegyd\eCommerce\Mails\AbstractMail;

class AlertStock extends AbstractMail
{

    protected $products;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $products)
    {
        parent::__constuct();
        $this->products = $products;
    }

    public function configure()
    {
        return [
            'prefixes' => [
                'lang' => 'hegyd-ecommerce::emails.products.stock-alert.',
                'view' => 'hegyd-ecommerce::emails.products.',
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
        $admins = app(config('hegyd-ecommerce.repositories.user'))->getAdminUsers();

        $this->subject($this->trans('subject'));
        $this->to($admins->pluck('email'));

        $this->with([
            'products' => $this->products,
        ]);

        $this->view($this->getView('stock-alert'));

        return $this;
    }
}