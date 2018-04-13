<?php

/**
 * Created by PhpStorm.
 * User: iturcanu
 * Date: 4/13/2018
 * Time: 3:52 PM
 */
namespace App\Abstracts;

use App\Models\Order;

abstract class DiscountChain{
    private $successor = null;

    final public function setSuccessor($handler){
        if ($this->successor === null) {
            $this->successor = $handler;
        } else {
            $this->successor->setSuccessor($handler);
        }
    }

    final public function handle(Order &$order, &$discount){
        $response = $this->applyDiscount($order, $discount);
        if (($response === null) && ($this->successor !== null)) {
            $response = $this->successor->handle($order, $discount);
        }

        return $response;
    }

    abstract protected function applyDiscount(Order &$order, &$discount);
}