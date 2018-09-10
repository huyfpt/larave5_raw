<?php namespace Hegyd\eCommerce\Console\Commands;


use Hegyd\eCommerce\Mails\ProductCatalog\AlertStock;
use Hegyd\eCommerce\Models\ProductCatalog\Product;
use Hegyd\eCommerce\Repositories\Contracts\ProductCatalog\ProductRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ProductStockAlertCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hegyd:ecommerce-product-stock-alert';

    /**
     *
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoi un mail avec les produits qui ont leur stock en dessous du seuil d\'alerte';

    /**
     *
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $products = app(ProductRepositoryInterface::class)->active();
        $alert_products = [];

        foreach ($products as $product)
        {
            if ($product->stock <= $product->stock_alert)
                $alert_products[] = $product;
        }

        if (count($alert_products))
        {
            Mail::queue(new AlertStock($alert_products));
        }
    }

}