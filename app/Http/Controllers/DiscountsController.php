<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Deserializers\OrderDeserializer;
use App\Models\Order;
use App\Product;
use App\Services\DiscountService;
use Illuminate\Support\Facades\App;

class DiscountsController extends Controller
{
    protected $discountApplier;
    protected $order;

    public function __construct()
    {
        $this->discountApplier = new DiscountService();
        $orderDeserializer = new OrderDeserializer();
        $this->order = $orderDeserializer->deserialize();
    }

    public function index()
    {
        return $this->discountApplier->getOrderDiscounts($this->order);
    }
}