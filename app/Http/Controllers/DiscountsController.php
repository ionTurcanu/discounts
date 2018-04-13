<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Models\Order;
use App\Product;
use App\Services\DiscountService;
use Illuminate\Support\Facades\App;

class DiscountsController extends Controller
{
    public $data;
    public $jsonData;

    public function index()
    {
        $order = (\App::make('App\Models\Order'))->getObject();
        return DiscountService::getOrderDiscounts($order);
    }
}