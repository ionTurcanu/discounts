<?php
/**
 * Created by PhpStorm.
 * User: iturcanu
 * Date: 4/13/2018
 * Time: 1:15 PM
 */

namespace App\Services;

use App\Models\Order;
use App\Services\ChainDiscounts\DiscountChain;

class DiscountService{
    public function getOrderDiscounts (Order $order) {
        DiscountChain::apply($order, $discounts);
        return $discounts;
    }
}