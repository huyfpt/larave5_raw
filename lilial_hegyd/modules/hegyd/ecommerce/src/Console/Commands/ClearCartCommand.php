<?php namespace Hegyd\eCommerce\Console\Commands;


use Carbon\Carbon;
use Hegyd\eCommerce\Mails\ProductCatalog\AlertStock;
use Hegyd\eCommerce\Models\eCommerce\Cart;
use Hegyd\eCommerce\Models\ProductCatalog\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ClearCartCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hegyd:ecommerce-clear-cart {--timing=4 : Le timing correspond au temps depuis lequel le panier a été mis à jour}';

    /**
     *
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Supprime les paniers qui n\'ont pas eu de modification depuis le timing indiqué (4h par défaut)';

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
        $timing = $this->option('timing');
        $date = Carbon::now()->subHours($timing);

        $carts = Cart::select('carts.*')
            ->join('cart_lines', 'carts.id', '=', 'cart_lines.cart_id')
            ->groupBy('carts.id')
            ->havingRaw('carts.updated_at < "' . $date . '"')
            ->havingRaw('MAX(cart_lines.updated_at) < "' . $date . '"')
            ->get();

        foreach ($carts as $cart)
        {
            $cart->delete();
        }
    }


}