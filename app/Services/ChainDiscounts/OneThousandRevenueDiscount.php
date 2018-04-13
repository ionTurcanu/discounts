<?php
/**
 * Created by PhpStorm.
 * User: iturcanu
 * Date: 4/13/2018
 * Time: 3:31 PM
 */
namespace App\Services\ChainDiscounts;
use App\Abstracts\DiscountChain;
use App\Models\Customer;
use App\Models\Order;

class OneThousandRevenueDiscount extends DiscountChain
{
    public function applyDiscount(Order &$order, &$discount)
    {
        $minRevenue = 1000;

        $order->total = $order->items->sum('total');

        $appliedDiscount = 0;
        if ($order->customer->revenue > $minRevenue) {
            $appliedDiscount = round($order->total * 0.2, 2);
            $order->total = $order->total - $appliedDiscount;
        }

        $discount['oneThousandRevenueDiscount'] = $appliedDiscount;
    }
}