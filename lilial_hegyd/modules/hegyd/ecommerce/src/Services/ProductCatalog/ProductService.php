<?php namespace Hegyd\eCommerce\Services\ProductCatalog;


use Hegyd\eCommerce\Models\eCommerce\CartLine;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\CartLineRepositoryInterface;

class ProductService
{

    public function priceTtc($product)
    {
        $vat_rate = 1;
        if ($vat = $product->vat)
            $vat_rate = (1 + ($vat->rate / 100));


        return $product->price * $vat_rate;
    }

    public function currentStock($product, $excluded_ids = [])
    {
        $cart_line_repository = app(CartLineRepositoryInterface::class);

        $stock = $product->stock;

        foreach ($cart_line_repository->findByProduct($product, $excluded_ids) as $cart_line)
        {
            $stock = $stock - $cart_line->quantity;
        }

        return $stock;
    }
    
    public function buildTableDeclension($product)
    {
        $json = json_decode($product->table_declension);
        if (empty($json)) {
            return [];
        }

        $var_header = ['variante_1', 'variante_2'];
        $var_value = ['valeur_variante', 'valeur_variante_2'];
        $i = 0;

        foreach ($json as $key=>$item) {
            if (in_array($key, $var_header)) {
                $return['columns'][] = $item;
            }
            elseif (in_array($key, $var_value)) {
                $return['rows'][$i][] = $item;
            }
            else {
                $return['columns'][] = $key;
                $return['rows'][$i][] = $item;
            }
        }

        return $return;
    }

}