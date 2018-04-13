<?php
/**
 * Created by PhpStorm.
 * User: iturcanu
 * Date: 4/13/2018
 * Time: 6:00 PM
 */

namespace App\Deserializers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;

class OrderDeserializer{

    public function deserialize(){
        $jsonOrder = json_decode(file_get_contents(storage_path('mocks/order-1.json')), 1);

        $order = new Order();
        $order->customer = Customer::find($jsonOrder['customer-id']);
        $order->fill(get_object_vars((object) $jsonOrder));

        $items = [];
        foreach ($order->items as $item) {
            $orderedItem = new \StdClass();
            $orderedItem->productId = $item['product-id'];
            $orderedItem->product = Product::find($item['product-id']);
            $orderedItem->quantity = $item['quantity'];
            $orderedItem->total = $item['total'];
            $orderedItem->unit_price = $item['unit-price'];

            $item = new Item();
            $item->fill(get_object_vars($orderedItem));
            $items[] = $item;
        }
        $order->items = collect($items);
        return $order;
    }
}
