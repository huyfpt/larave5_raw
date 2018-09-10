<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\ProductRepositoryInterface;

class BlockHomeProduct extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    public $cacheTime = 60;

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $repository = app(ProductRepositoryInterface::class);

        $data = $repository->getProductLastest();

        return view('widgets.block_home_product', [
            'config' => $this->config,
            'data' => $data
        ]);
    }
}
