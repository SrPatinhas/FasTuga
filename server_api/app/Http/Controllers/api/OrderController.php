<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{

    public function index()
    {
        // Filter by Auth user_id
        return OrderResource::collection(Order::whereNotNull('customer_id')->get());
    }
    // Check if order is from Auth user_id
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function store(StoreUpdateOrderRequest $request)
    {
        $newOrder = Order::create($request->validated());
        return new OrderResource($newOrder);
    }

    public function update(StoreUpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        return new OrderResource($order);
    }

    public function destroy(Order $order)
    {
        Order::where("order_id", $order->id)->delete();
        $order->delete();
        return new OrderResource($order);
    }


    public function update_completed(UpdateCompleteOrderRequest $request, Order $order)
    {
        $order->completed = $request->validated()['completed'];
        $order->save();
        return new OrderResource($order);
    }



    public function getOrdersOfProduct(Request $request, Product $product)
    {
        //OrderResource::$format = 'detailed';
        if (!$request->has('include_assigned')) {
            return OrderResource::collection($product->Orders->sortByDesc('id'));
        } else {
            return OrderResource::collection($product->Orders->merge($product->assigedOrders)->sortByDesc('id'));
        }
    }
}
