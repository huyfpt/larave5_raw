<?php namespace Hegyd\eCommerce\Providers;


use Hegyd\eCommerce\Repositories\Contracts\eCommerce\CartLineRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\CartRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\OrderHistoryRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\OrderLineRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\OrderRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\VatRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\CategoryRepositoryInterface;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\ProductRepositoryInterface;
use Hegyd\eCommerce\Repositories\Eloquent\eCommerce\CartLineRepository;
use Hegyd\eCommerce\Repositories\Eloquent\eCommerce\CartRepository;
use Hegyd\eCommerce\Repositories\Eloquent\eCommerce\OrderHistoryRepository;
use Hegyd\eCommerce\Repositories\Eloquent\eCommerce\OrderLineRepository;
use Hegyd\eCommerce\Repositories\Eloquent\eCommerce\OrderRepository;
use Hegyd\eCommerce\Repositories\Eloquent\eCommerce\VatRepository;
use Hegyd\eCommerce\Repositories\Eloquent\ProductCatalog\CategoryRepository;
use Hegyd\eCommerce\Repositories\Eloquent\ProductCatalog\ProductRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        /*
         * Bind repositories
         */
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);

        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(CartLineRepositoryInterface::class, CartLineRepository::class);

        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderLineRepositoryInterface::class, OrderLineRepository::class);
        $this->app->bind(OrderHistoryRepositoryInterface::class, OrderHistoryRepository::class);

        $this->app->bind(VatRepositoryInterface::class, VatRepository::class);
    }
}