<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['id', 'customer_id', 'items', 'total'];

    public function getObject(){
        $file = json_decode(file_get_contents(storage_path('mocks/order-1.json')));
        $order = new Order();
        $order->fill(get_object_vars($file));
        $order->items = collect($order->items);
        return $order;
    }
}