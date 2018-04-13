<?php
/**
 * Created by PhpStorm.
 * User: iturcanu
 * Date: 4/13/2018
 * Time: 1:15 PM
 */

namespace App\Services;

use App\Models\Order;
use App\Services\ChainDiscounts\DiscountApplierService;

class DiscountService{
    public static function getOrderDiscounts (Order $order) {
        $discount = array();
        DiscountApplierService::apply($order, $discount);
        return $discount;
    }
}