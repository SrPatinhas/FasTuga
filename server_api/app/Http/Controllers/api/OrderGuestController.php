<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentOrderRequest;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderStatusResource;
use App\Http\Resources\BoardItemsResource;
use App\Models\Customer;
use App\Models\OrderItem;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utils;

class OrderGuestController extends Controller
{

    public function showGuest (Order $order)
    {
        if($order->customer_id != null){
            return response()->json(['message' => 'This order needs to have a user logged in to see'], 401);
        }
        return new OrderDetailResource($order);
    }

    public function getOrderStatusGuest(Order $order)
    {
        if($order->customer_id != null){
            return response()->json(['message' => 'This order needs to have a user logged in to see'], 401);
        }
        return new OrderStatusResource($order);
    }

    //por fazer
    public function getBoardItems (Order $order)
    {
        $preparing = BoardItemsResource::collection($order->where('status', 'P')->orderBy('updated_at', 'desc')->get());
        $ready = BoardItemsResource::collection($order->where('status', 'R')->orderBy('updated_at', 'desc')->get());
        return response()->json(['ready' => $ready, 'preparing' => $preparing]);
    }

    public function paymentGuest(PaymentOrderRequest $request)
    {
        $customerId = null;
        if(Auth::hasUser() && Auth::user()->getIsCustomer()){
            $customerId = Auth::user()->customer->id;
        }
        $total_order = 0;

        $products = [];
        $local_number = 0;
        // get the real value from DB (prevent any security breach
        foreach ($request->items as $item){
            $local_number += 1;
            $product = Product::find($item['id']);
            $product_total = $product->price * $item['quantity'];
            $total_order += $product_total;
            if($product->price != $item["price"]){
                return response()->json(['message' => 'Price of the product dont match'], 400);
            }
            // create new array to prevent multiple calls to the DB next
            $newItem = [
                'product_id'    => $product->id,
                'status'        => $product->type == 'hot dish' ? 'W' : 'R', // 'hot' = 'Waiting' : 'Ready'
                'price'         => $product->price,
                'quantity'      => $item['quantity'],
                'local_number'  => $local_number,
            ];
            $products[] = $newItem;
        }

        $utils = new Utils();
        // check if the values are valid for payment
        if(!$utils->checkPayment($request->checkout['pay_type'], $request->checkout['pay_reference'], $total_order)){
            return response()->json(['message' => 'The payment values are not valid'], 400);
        }
        // call the payment server
        if(!$utils->callPaymentGateway($request->checkout['pay_type'], $request->checkout['pay_reference'], $total_order)){
            return response()->json(['message' => 'The payment values are not valid by the payment server'], 400);
        }

        // validates the ticket number
        $last_ticket = Order::latest()->first()->ticket_number;
        if($last_ticket == 99){
            $last_ticket = 0;
        }
        $current_date = Carbon::now();
        $order = Order::create([
            'ticket_number'             => $last_ticket + 1,
            'status'                    => 'P',
            'customer_id'               => $customerId,
            'total_price'               => $total_order,
            'total_paid'                => $total_order,
            'total_paid_with_points'    => 0,
            'points_gained'             => 0,
            'points_used_to_pay'        => 0,
            'payment_type'              => $request->checkout['pay_type'],
            'payment_reference'         => $request->checkout['pay_reference'],
            'date'                      => $current_date->toDateString(),
            'created_at'                => $current_date,
            'updated_at'                => $current_date,
            'notes'                     => $request->notes,
        ]);

        foreach ($products as $prod) {
            OrderItem::create([
                'order_id'              => $order->id,
                'order_local_number'    => $prod['local_number'],
                'product_id'            => $prod['product_id'],
                'product_quantity'      => $prod['quantity'],
                'status'                => $prod['status'],
                'price'                 => $prod['price'],
                'notes'                 => $request->notes,
            ]);
        }

        return new OrderDetailResource($order);
    }
}
