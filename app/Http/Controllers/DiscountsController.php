<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Product;

class DiscountsController extends Controller
{
    public $data;
    public $jsonData;

    public function __construct()
    {
        $this->jsonData = '{
          "id": "3",
          "customer-id": "3",
          "items": [
            {
              "product-id": "A101",
              "quantity": "2",
              "unit-price": "9.75",
              "total": "19.50"
            },
            {
              "product-id": "A102",
              "quantity": "1",
              "unit-price": "49.50",
              "total": "49.50"
            },
            {
              "product-id": "B102",
              "quantity": "57",
              "unit-price": "49.50",
              "total": "2475"
            },
            {
              "product-id": "B101",
              "quantity": "18",
              "unit-price": "49.50",
              "total": "891"
            }
          ],
          "total": "69.00"
        }';


        $this->data = json_decode($this->jsonData);
        $this->data->items = collect($this->data->items);
    }

    public function index()
    {
        $this->applyDiscountOnCheapestCategoryItem(1, 20)
            ->applyDiscountByCategory(6, 2)
            ->refreshTotalPrice()
            ->apply20PercentDiscount(1000);

        return response()->json($this->data);
    }

    public function applyDiscountOnCheapestCategoryItem($categoryId = 0, $discount = 20)
    {
        if (!$categoryId or !$discount) {
            return $this->data;
        } else {
            $groupProducts = Product::where('category', '=', $categoryId)->pluck('category', 'id')->keys();
            $cheapest = $this->data->items->whereIn('product-id', $groupProducts)->sortBy('total')->first();
            if ($cheapest) {
                $cheapest->total = $cheapest->total - $cheapest->total * $discount / 100;
            }
            return $this;
        }
    }

    public function applyDiscountByCategory($freeProduct = 5, $categoryId = 0)
    {
        if (!$categoryId or !$freeProduct) {
            return $this;
        } else {
            $groupProducts = Product::where('category', '=', $categoryId)->pluck('category', 'id')->keys();
            $orderProducts = $this->data->items->whereIn('product-id', $groupProducts);

            foreach ($orderProducts as $product) {
                $productArray = collect($product)->toArray();
                if ($product->quantity > $freeProduct) {
                    $recalcSum = round($product->quantity / $freeProduct, 0, PHP_ROUND_HALF_DOWN) * $productArray['unit-price'];
                    $product->total -= $recalcSum;
                }
            }
            return $this;
        }
    }

    public function apply20PercentDiscount($minRevenue = 1000)
    {
        $order = collect($this->data);
        $customer = Customer::find($order['customer-id']);

        if ($customer->revenue > $minRevenue) {
            $this->data->total = $this->data->total * 0.8;
        }

        return $this;
    }

    public function refreshTotalPrice()
    {
        $this->data->total = $this->data->items->sum('total');
        return $this;
    }
}
