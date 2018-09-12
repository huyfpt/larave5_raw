<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class BlockFooterLink extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {

        if (Cache::has('BlockFooterLink')) {
            $data = Cache::get('BlockFooterLink');
        }
        else {
            $repository = app(CategoryRepositoryInterface::class);

            $root_category = $repository->findRootCatgory();
            if (!empty($root_category)) {
                foreach ($root_category as $parent_id) {
                    $data[] = $repository->findSubCategory($parent_id);
                }

                Cache::forever('BlockFooterLink', $data);
            }
        }

        return view('widgets.block_footer_link', [
            'config' => $this->config,
            'data' => $data,
        ]);
    }
}
