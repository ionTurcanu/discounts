<?php

/**
 * Created by PhpStorm.
 * User: iturcanu
 * Date: 4/13/2018
 * Time: 3:29 PM
 */
namespace App\Services\ChainDiscounts;

use App\Abstracts\DiscountChain;
use App\Models\Order;
use App\Models\Product;

class SecondCategoryItemDiscount extends DiscountChain
{
    public function applyDiscount(Order &$order, &$discount)
    {
        $categoryId = 2;
        $freeProduct = 6;
        $groupProducts = Product::where('category', '=', $categoryId)->pluck('category', 'id')->keys();
        $orderedProducts = $order->items->whereIn('productId', $groupProducts);
        $appliedDiscount = 0;
        foreach ($orderedProducts  as $orderedProduct) {
            if ($orderedProduct->quantity >= $freeProduct) {
                $recalcSum = round($orderedProduct->quantity / $freeProduct, 0, PHP_ROUND_HALF_DOWN)
                    * $orderedProduct->unit_price;
                $orderedProduct->total -= $recalcSum;
                $appliedDiscount += $recalcSum;
            }
        }

        $discount['secondCategoryItemDiscount'] = $appliedDiscount;
    }
}