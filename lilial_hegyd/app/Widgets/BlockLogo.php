<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Hegyd\eCommerce\Repositories\Eloquent\ProductCatalog\BrandRepository;

class BlockLogo extends AbstractWidget
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
        $repository = app(BrandRepository::class);
        $data = $repository->getAll();

        return view('widgets.block_logo', [
            'config' => $this->config,
            'data' => $data
        ]);
    }
}
