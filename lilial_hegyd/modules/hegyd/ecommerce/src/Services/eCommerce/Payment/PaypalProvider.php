<?php namespace Hegyd\eCommerce\Services\eCommerce\Payment;

use Carbon\Carbon;
use Hegyd\eCommerce\Models\eCommerce\Order;
use Hegyd\eCommerce\Services\eCommerce\CartService;
use Hegyd\eCommerce\Support\PaymentLogger;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaypalProvider implements PaymentProvider
{

    protected $logger;

    public function __construct()
    {
        $this->logger = new PaymentLogger('paypal.log');
    }

    public function processPayment($cart)
    {
        $this->logger->info("processPayment:: Cart :#$cart->id -- Start");

        $apiContext = $this->_getApiContext();

        $baseUrl = env('APP_URL');
        $currency = 'EUR';

        $cartService = new CartService();

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $items = [];
        foreach ($cart->lines as $line)
        {
            $product = $line->product;
            $item = new Item();
            $item->setName($product->name)
                ->setDescription($product->description)
                ->setSku(substr($product->reference, 0, 127))
                ->setPrice($product->price)
                ->setCurrency($currency)
                ->setQuantity($line->quantity);

            $items[] = $item;
        }

        $itemList = new ItemList();
        $itemList->setItems($items);

        $details = new Details();
        $details->setShipping($cartService->deliveryPrice($cart))
            ->setTax($cartService->vatPrice($cart))
            ->setSubtotal($cartService->totalLinesPrice($cart));

        $amount = new Amount();
        $amount->setCurrency($currency)
            ->setTotal($cartService->totalPrice($cart, true))
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route(config('hegyd-ecommerce.routes.frontend.cart.payment-success')))
            ->setCancelUrl(route(config('hegyd-ecommerce.routes.frontend.cart.payment-failed')));

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try
        {
            $this->logger->info("processPayment:: Cart :#$cart->id -- Before create");
            $payment->create($apiContext);
            $this->logger->info("processPayment:: Cart :#$cart->id -- After create");
        } catch (Exception $ex)
        {
            $this->logger->error("processPayment:: Cart :#$cart->id -- Error create", [$ex]);

        }

        $cart->payment_id = $payment->getId();
        $cart->save();

        $this->logger->info("processPayment:: Cart :#$cart->id -- PaymentId :  $cart->payment_id");

        $approvalUrl = $payment->getApprovalLink();

        return redirect()->away($approvalUrl);
    }

    /**
     * @param $order
     * @param $request
     */
    public function validatePayment($order, $request)
    {
        $this->logger->info("validatePayment:: ", [$request->all()]);

        $payment_id = $request->get('paymentId');
        $payer_id = $request->get('PayerID');

        $this->_executePayment($payment_id, $payer_id, $order);
    }

    private function _executePayment($payment_id, $payer_id, $order)
    {
        $this->logger->info("_executePayment:: PaymentID : $payment_id | PayerID :: $payer_id");

        $payment = Payment::get($payment_id, $this->_getApiContext());

        $execution = new PaymentExecution();
        $execution->setPayerId($payer_id);

        $apiContext = $this->_getApiContext();

        try
        {
            $result = $payment->execute($execution, $apiContext);
            $this->logger->info("Executed Payment");
            $this->logger->info("Payment");
            $this->logger->info($payment->getId());
            $this->logger->info($execution);
            $this->logger->info($result);
            try
            {
                $payment = Payment::get($payment_id, $apiContext);
            } catch (Exception $ex)
            {
                $this->logger->error("Get Payment");
                $this->logger->error("Payment");
                $this->logger->error($ex);
                exit(1);
            }
        } catch (Exception $ex)
        {
            $this->logger->error("Executed Payment");
            $this->logger->error("Payment");
            $this->logger->error($ex);
            exit(1);
        }
        $this->logger->info("Get Payment");
        $this->logger->info("Payment");
        $this->logger->info($payment->getId());
        $this->logger->info($payment);

        $order->status = Order::STATUS_PAID;
        $order->paid_at = Carbon::now();
        $order->payment_id = $payment_id;

        $order->save();
    }

    private function _getConfig($key = null)
    {
        $config = config('hegyd-ecommerce.payments.paypal');

        if ($key)
        {
            if (isset($config[$key]))
                return $config[$key];

            return null;
        }

        return $config;
    }

    private function _getApiContext()
    {
        $config = $this->_getConfig();
        $settings = $config['settings'];

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $config['username'],
                $config['password']
            )
        );

        $apiContext->setConfig([
            'mode'           => $settings['mode'],
            'log.LogEnabled' => $settings['logs']['enable'],
            'log.FileName'   => $settings['logs']['filepath'],
            'log.LogLevel'   => $settings['logs']['level'],
        ]);

        return $apiContext;
    }
}