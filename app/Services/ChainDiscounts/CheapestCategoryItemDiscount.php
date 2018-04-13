<?php
namespace App\Services\ChainDiscounts;
use App\Abstracts\DiscountHandler;
use App\Models\Order;
use App\Models\Product;

/**
 * Created by PhpStorm.
 * User: iturcanu
 * Date: 4/13/2018
 * Time: 3:29 PM
 */
class CheapestCategoryItemDiscount  extends DiscountHandler {
    /**
     * @param Order $order
     * @return $this
     */
    public function applyDiscount(Order &$order, &$discount) {
        $categoryId = 1;
        $appliedDiscount = 20;
        $groupProducts = Product::where('category', '=', $categoryId)->pluck('category', 'id')->keys();
        $cheapest = $order->items->whereIn('product_id', $groupProducts)->sortBy('total')->first();
        $toSubstract = 0;
        if ($cheapest) {
            $toSubstract = $cheapest->total * $appliedDiscount / 100;
            $cheapest->total = $cheapest->total - $toSubstract;
        }
        $discount['cheapestCategoryItemDiscount'] = $toSubstract;
    }
}