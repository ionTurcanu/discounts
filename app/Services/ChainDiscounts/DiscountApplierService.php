<?php
/**
 * Created by PhpStorm.
 * User: iturcanu
 * Date: 4/13/2018
 * Time: 5:22 PM
 */
namespace App\Services\ChainDiscounts;

class DiscountApplierService{
    public static function apply(&$order, &$discount) {
        $cheapestDiscount = new CheapestCategoryItemDiscount();
        $secondDiscount = new SecondCategoryItemDiscount();
        $thirdDiscount = new OneThousandRevenueDiscount();
        $cheapestDiscount->setSuccessor($secondDiscount);
        $cheapestDiscount->setSuccessor($thirdDiscount);
        $cheapestDiscount->handle($order, $discount);
    }
}