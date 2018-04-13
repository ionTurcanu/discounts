<?php
/**
 * Created by PhpStorm.
 * User: iturcanu
 * Date: 4/13/2018
 * Time: 3:31 PM
 */
namespace App\Services\ChainDiscounts;
use App\Abstracts\DiscountHandler;
use App\Models\Customer;
use App\Models\Order;

class OneThousandRevenueDiscount extends DiscountHandler
{
    public function applyDiscount(Order &$order, &$discount)
    {
        $minRevenue = 1000;
        $customer = Customer::find($order->customer_id);

        $order->total = $order->items->sum('total');

        $appliedDiscount = 0;
        if ($customer->revenue > $minRevenue) {
            $appliedDiscount = $order->total * 0.2;
            $order->total = $order->total - $appliedDiscount;
        }

        $discount['oneThousandRevenueDiscount'] = $appliedDiscount;
    }
}