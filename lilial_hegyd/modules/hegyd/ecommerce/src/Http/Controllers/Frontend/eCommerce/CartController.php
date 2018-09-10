<?php namespace Hegyd\eCommerce\Http\Controllers\Frontend\eCommerce;

use Hegyd\eCommerce\Http\Controllers\AbstractController;
use Hegyd\eCommerce\Http\Controllers\Frontend\AbstractFrontendController;
use Hegyd\eCommerce\Http\Controllers\Traits\Apiable;
use Hegyd\eCommerce\Events\Notifications\eCommerce\NewOrderEvent;
use Hegyd\eCommerce\Models\eCommerce\Cart;
use Hegyd\eCommerce\Models\eCommerce\CartLine;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\CartLineRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\CartRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\OrderRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\ProductRepositoryInterface;
use Hegyd\eCommerce\Services\eCommerce\CartService;
use Hegyd\eCommerce\Services\ProductCatalog\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CartController extends AbstractController
{

    use Apiable;

    protected $cartService;
    protected $cartLineRepository;
    protected $productRepository;
    protected $addressClass;
    protected $addressRepository;

    public function __construct(Request $request, CartRepositoryInterface $repository,
                                CartLineRepositoryInterface $cartLineRepository,
                                ProductRepositoryInterface $productRepository)
    {
        parent::__construct($request);
        $this->repository = $repository;
        $this->cartLineRepository = $cartLineRepository;
        $this->cartService = app(CartService::class);
        $this->productRepository = $productRepository;
        $this->addressClass = config('hegyd-ecommerce.models.address');
        $this->addressRepository = config('hegyd-ecommerce.repositories.address');
    }

    public function index()
    {
        $this->currentCart();

        $this->breadcrumbs->addCrumb(trans('app.dashboard'), route('index'));
        $title = trans('hegyd-ecommerce::cart.title.index');
        $this->breadcrumbs->addCrumb($title, route(config('hegyd-ecommerce.routes.frontend.cart.index')));


        if (auth()->guest())
        {
            session()->put('url.intended', route(config('hegyd-ecommerce.routes.frontend.cart.index')));
        }

        $this->setDefaultAddresses();

        return view('hegyd-ecommerce::frontend.contents.cart.index')->with(compact('title'));
    }

    public function popup()
    {
        return view('hegyd-ecommerce::frontend.contents.cart.includes.cart-popup');
    }

    /**
     * Ajoute un produit au panier
     */
    public function add()
    {
        $cartLine = $this->getCartLineByRequest(['quantity' => 'required|integer']);

        $status = Response::HTTP_OK;
        $datas = [];

        if ($quantity = $this->getRequest()->get('quantity'))
        {
            $stock = app(ProductService::class)->currentStock($cartLine->product);
            if ($stock > 0)
            {
                if ($stock < $quantity)
                {
                    $quantity = $stock;

                    $datas = ['text' => trans('hegyd-ecommerce::products.labels.no_total_stock'), 'warning' => true];
                }

                $quantity += $cartLine->quantity;
                $this->setCartLine($cartLine, $quantity);
            } else
            {
                $status = Response::HTTP_IM_USED;
                $datas = ['text' => trans('hegyd-ecommerce::products.labels.no_more_stock')];
            }

        }

        return $this->sendResponse($status, $datas);
    }

    /**
     * Ajoute des produits en masse au panier
     */
    public function addBulk()
    {
        $items = $this->getRequest()->get('items', []);

        foreach ($items as $item)
        {
            if (isset($item['product_id']) && isset($item['quantity']))
            {
                $product = $this->productRepository->find((int) $item['product_id']);
                if ($product)
                {
                    $cartLine = $this->getCartLineByProductId($product->id);
                    $quantity = (int) $item['quantity'];
                    if ($quantity)
                    {
                        $stock = app(ProductService::class)->currentStock($cartLine->product);
                        if ($stock > 0)
                        {
                            if ($stock < $quantity)
                            {
                                $quantity = $stock;
                            }
                            $quantity += $cartLine->quantity;
                            $this->setCartLine($cartLine, $quantity);
                        }
                    }
                }
            }
        }

        return $this->sendResponse();
    }

    /**
     * Met à jour un produit du panier
     * @param Request $request
     */
    public function update()
    {
        if ( ! $this->getRequest()->get('update-cart', false))
        {
            $cartLine = $this->getCartLineByRequest([], false);

            if ($cartLine)
            {

                $status = Response::HTTP_OK;
                $datas = [];

                $quantity = $this->getRequest()->get('quantity', false);
                $stock = app(ProductService::class)->currentStock($cartLine->product, [$cartLine->id]);
                if ($stock > 0)
                {
                    if ($stock < $quantity)
                    {
                        $quantity = $stock;
                        $datas = ['text' => trans('hegyd-ecommerce::products.labels.no_total_stock'), 'warning' => true];
                    }

                    $this->setCartLine($cartLine, $quantity);
                } else
                {
                    $status = Response::HTTP_IM_USED;
                    $datas = ['text' => trans('hegyd-ecommerce::products.labels.no_more_stock')];
                }

                return $this->sendResponse($status, $datas);
            }
        } else
        {
            $cart = $this->currentCart();
            $toUpdate = false;

            if ($this->getRequest()->exists('comment'))
            {
                $cart->comment = $this->getRequest()->get('comment');
                $toUpdate = true;
            }
            if ($this->getRequest()->exists('payment_means'))
            {
                $cart->payment_means = $this->getRequest()->get('payment_means');
                $toUpdate = true;
            }

            if ($toUpdate)
            {
                $this->repository->updateRich($cart->getAttributes(), $cart->id);
                view()->share('cart', $cart);
            }

            return $this->sendResponse();
        }

        abort(404);
    }

    /**
     * Supprime le produit du panier
     */
    public function remove()
    {
        $rules = ['product_id' => 'required|integer|exists:products,id'];

        $this->validate($this->getRequest(), $rules);
        $attributes = [
            'cart_id'    => $this->currentCart()->id,
            'product_id' => $this->getRequest()->get('product_id'),
        ];

        $cartLines = $this->cartLineRepository->findWhere($attributes);
        foreach ($cartLines as $cartLine)
        {
            $this->cartLineRepository->delete($cartLine->id);
        }

        return $this->sendResponse();
    }

    /**
     * Remet à zéro le panier
     */
    public function reset()
    {
        $cart = $this->currentCart();
        $this->repository->delete($cart->id);


        return $this->sendResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResponse($status = Response::HTTP_OK, $additional_datas = [])
    {
        $response = [];
        $templates = $this->getRequest()->get('return_templates');

        return $this->templatesResponse($templates, $status, $additional_datas);
    }

    protected function templatesResponse($templates, $status = Response::HTTP_OK, $additional_datas = [])
    {
        if ($templates && is_array($templates))
        {
            foreach ($templates as $template)
            {
                $view = 'hegyd-ecommerce::frontend.contents.cart.includes.' . $template;

                if (view()->exists($view))
                {
                    $data = [];
                    if ($template == 'cart-details')
                    {
                    } else if ($template == 'cart-popup')
                    {
                        if ($status == Response::HTTP_OK)
                            $data['success'] = true;

                        if (isset($additional_datas['text']))
                            $data['text'] = $additional_datas['text'];
                    }
                    $response['templates'][$template] = view($view, $data)->render();
                }
            }
        }

        $response = array_merge($additional_datas, $response);

        if ($status == Response::HTTP_OK)
            return $this->successJsonResponse($status, $response);

        return $this->failureJsonResponse($status, $response);
    }


    /**
     * Retourne une cartLine en fonction de la requete passée en paramètre
     * ainsi que les règles qu'elle doit respecter
     * Une vérification des permissions peut être fait
     * @param array $rules
     * @param bool|false $handlePermissions
     * @param bool|true $orNew Si non trouvé, retourne un nouvel objet
     * @return CartLine
     */
    protected function getCartLineByRequest(array $rules, $orNew = true)
    {
        $rules += ['product_id' => 'required|integer|exists:products,id'];
        $this->validate($this->getRequest(), $rules);
        $cartLine = $this->getCartLineByProductId($this->getRequest()->get('product_id'), $orNew);

        return $cartLine;
    }

    /**
     * @param $productId
     * @param bool|true $orNew Si non trouvé, retourne un nouvel objet
     * @return CartLine
     */
    protected function getCartLineByProductId($productId, $orNew = true)
    {
        $product = $this->productRepository->findOrFail($productId);
        $cart = $this->currentCart();

        return $this->cartLineRepository->findByCartProduct($cart, $product, $orNew);
    }

    /**
     * Sauvegarde une CartLine
     * @param CartLine $cartLine
     * @param int $quantity
     */
    protected function setCartLine(CartLine $cartLine, $quantity = 0)
    {
        if ($quantity !== false)
        {
            if ($quantity !== false)
            {
                if ($quantity <= 0)
                    $quantity = 1;

                $cartLine->quantity = $quantity;
            }

            $this->cartLineRepository->setMyModel($cartLine);
            $this->cartLineRepository->save($cartLine->getAttributes());
        }
    }

    /**
     * Retourne le panier courant en fonction de l'utilisateur connecté ou du remember token en session
     * @return Cart
     */
    protected function currentCart()
    {
        return $this->cartService->currentCart();
    }

    /**
     * Action de paiement du panier
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function payment()
    {
        $cart = $this->currentCart();

        if ($this->cartService->cartCanBeValidated($cart))
        {

            return app(CartService::class)->getPaymentProvider($cart)->processPayment($cart);

            if ($ok && false)
            {
                $order = $this->cartService->convertCartToOrder($cart);
                $this->repository->delete($cart->id);
            }

            return redirect(route(config('hegyd-ecommerce.routes.frontend.cart.validate-confirm'), ['id' => $order->id]));
        }

        return redirect()->back();
    }

    /**
     * Fonction de retour du paiement lors d'un succès
     *
     * Paypal renvoit un paramètre paymentId qui correspond à l'identifiant du paiement
     * Cette information est stocké dans le champ payment_id du cart
     *
     * Pour les autres moyens de paiement, s'ils ne renvoient pas d'identifiant unique, vous pouvez,
     * avant la redirection vers l'interface, enregistrer un token dans ce champs.
     * C'est plus propre que d'utiliser l'identifiant du panier.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paymentSuccess()
    {
        $cart = $this->repository->findByPaymentId($this->getRequest()->get('paymentId'));
        if ($cart)
        {
            $order = $this->cartService->convertCartToOrder($cart);
            app(CartService::class)->getPaymentProvider($cart)->validatePayment($order, $this->getRequest());

            $this->repository->delete($cart->id);

            event(new NewOrderEvent($order));

            $title = trans('hegyd-ecommerce::orders.title.payment_success');

            return view('hegyd-ecommerce::frontend.contents.payment.success', compact('title', 'order'));
        }

        return redirect()->route(config('hegyd-ecommerce.routes.frontend.cart.index'));
    }

    public function paymentFailed()
    {
        $title = trans('hegyd-ecommerce::orders.title.payment_failed');

        return view('hegyd-ecommerce::frontend.contents.payment.failed', compact('title'));
    }

    /**
     * Affectation des adresses facturation/livraison du cart
     */
    protected function setDefaultAddresses()
    {
        $user = auth()->user();
        if ( ! $user)
            return;

        $cart = $this->currentCart();
        $needUpdate = false;
        $company_addres = null;


        /**
         * Si l'utilisateur est lié à un client,
         * Que ce client est taggé comme adresse de facturation
         *
         * => On met l'adresse du client comme celle de facturation
         */
        if ($user->company && $user->company->billable && ! $cart->invoiceAddress)
        {
            $company_addres = $user->company->address;
            $cart->invoiceAddress()->associate($company_addres);
            $needUpdate = true;
        }

        /**
         * Si l'utilisateur à des adresses liées, on lui affecte à celle de livraison et de facturation
         */
        if ($user->addresses->count())
        {
            if ( ! $cart->invoiceAddress)
            {
                $cart->invoiceAddress()->associate($user->addresses->first());
                $needUpdate = true;
            }
            if ( ! $cart->deliveryAddress)
            {
                $cart->deliveryAddress()->associate($user->addresses->first());
                $needUpdate = true;
            }
        }

        /**
         * Si l'adresse de livraison du cart est vide,
         * et que nous avons une adresse de client non null
         *
         * => On met l'adresse du client comme celle de livraison
         */
        if ( ! $cart->deliveryAddress && $company_addres)
        {
            $cart->deliveryAddress()->associate($company_addres);
            $needUpdate = true;
        }

        /**
         * Si needUpdate, MAJ du cart en base
         */
        if ($needUpdate)
        {
            $this->repository->updateRich($cart->getAttributes(), $cart->id);
            view()->share('cart', $cart);
        }
    }

    public function addressList()
    {
        $title = trans('hegyd-ecommerce::cart.title.choose_address');
        $route = config('hegyd-ecommerce.routes.frontend.cart.address.choosed');
        $method = 'POST';
        $addresses = auth()->user()->addresses;

        $type = $this->getRequest()->get('type');

        return view('hegyd-ecommerce::frontend.contents.cart.includes.addresses.list')->with(compact('title', 'route', 'method', 'addresses', 'type'));
    }

    public function addressChoosed()
    {
        $this->validate($this->getRequest(), [
            'address_id' => 'required',
            'type'       => 'required',
        ]);

        $address = app($this->addressRepository)->findOrFail($this->getRequest()->get('address_id'));

        $type = $this->getRequest()->get('type');
        $this->_setAddressToCart($address, $type);


        return $this->templatesResponse(['cart-details']);
    }

    public function addressAdd()
    {
        $title = trans('hegyd-ecommerce::cart.title.add_address');
        $route = config('hegyd-ecommerce.routes.frontend.cart.address.store');
        $method = 'POST';
        $model = app($this->addressClass);

        $type = $this->getRequest()->get('type');

        return view('hegyd-ecommerce::frontend.contents.cart.includes.addresses.form')->with(compact('title', 'route', 'method', 'model', 'type'));
    }

    public function addressStore()
    {
        $user = auth()->user();

        if ( ! $user)
            abort(500);

        $this->validate($this->getRequest(), [
            'address' => 'required',
            'zip'     => 'required',
            'city'    => 'required',
            'type'    => 'required',
        ]);

        $address = app($this->addressClass);
        $address->fill($this->getRequest()->all());
        $user->addresses()->save($address);

        $type = $this->getRequest()->get('type');

        $this->_setAddressToCart($address, $type);

        return $this->templatesResponse(['cart-details']);
    }

    public function addressEdit($id)
    {
        $title = trans('hegyd-ecommerce::cart.title.edit_address');
        $route = [config('hegyd-ecommerce.routes.frontend.cart.address.update'), $id];
        $method = 'PUT';
        $model = app($this->addressRepository)->findOrFail($id);

        $type = $this->getRequest()->get('type');

        return view('hegyd-ecommerce::frontend.contents.cart.includes.addresses.form')->with(compact('title', 'route', 'method', 'model', 'type'));
    }

    public function addressUpdate($id)
    {
        $user = auth()->user();

        if ( ! $user)
            abort(500);

        $this->validate($this->getRequest(), [
            'address' => 'required',
            'zip'     => 'required',
            'city'    => 'required',
            'type'    => 'required',
        ]);

        $addressRepository = app($this->addressRepository);
        $address = $addressRepository->findOrFail($id);
        $address->fill($this->getRequest()->all());

        $addressRepository->reset();
        $addressRepository->updateRich($address->getAttributes(), $id);

        $type = $this->getRequest()->get('type');

        $this->_setAddressToCart($address, $type);

        return $this->templatesResponse(['cart-details']);
    }

    private function _setAddressToCart($address, $type)
    {
        if ( ! $address instanceof $this->addressClass)
            abort(500);

        $cart = $this->currentCart();

        if ($type == Cart::ADDRESS_TYPE_INVOICE)
        {
            $cart->invoiceAddress()->associate($address);
        } else if ($type == Cart::ADDRESS_TYPE_DELIVERY)
        {
            $cart->deliveryAddress()->associate($address);
        }

        $this->repository->updateRich($cart->getAttributes(), $cart->id);
        view()->share('cart', $cart);
    }

    /**
     * Configure Breadcrumb
     *
     * @return array
     */
    protected function configureBreadcrumb()
    {
        $config = parent::configureBreadcrumb();
        $config['namespace'] = config('hegyd-ecommerce.view-namespace.frontend');

        return $config;
    }
}