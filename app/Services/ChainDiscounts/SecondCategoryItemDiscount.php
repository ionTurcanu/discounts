<?php

/**
 * Created by PhpStorm.
 * User: iturcanu
 * Date: 4/13/2018
 * Time: 3:29 PM
 */
namespace App\Services\ChainDiscounts;

use App\Abstracts\DiscountHandler;
use App\Models\Order;
use App\Models\Product;

class SecondCategoryItemDiscount extends DiscountHandler
{
    public function applyDiscount(Order &$order, &$discount)
    {
        $categoryId = 2;
        $freeProduct = 6;
        $groupProducts = Product::where('category', '=', $categoryId)->pluck('category', 'id')->keys();
        $orderedProducts = $order->items->whereIn('product_id', $groupProducts);

        $appliedDiscount = 0;
        foreach ($orderedProducts  as $product) {
            if ($product->quantity >= $freeProduct) {
                $recalcSum = round($product->quantity / $freeProduct, 0, PHP_ROUND_HALF_DOWN) * $product->unit_price;
                $product->total -= $recalcSum;
                $appliedDiscount += $recalcSum;
            }
        }

        $discount['secondCategoryItemDiscount'] = $appliedDiscount;
    }
}