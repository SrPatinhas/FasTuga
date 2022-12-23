<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentOrderRequest;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderKitchenResource;
use App\Http\Resources\OrderResource;
use App\Models\Customer;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utils;

class OrderController extends Controller
{

    public function index()
    {
        if(Auth::user()->getIsCustomer()){
            $orders = Order::where('customer_id', Auth::user()->customer->id);
        } else {
            $orders = Order::whereNotNull('customer_id');
        }
        return OrderResource::collection($orders->orderBy('updated_at', 'desc')->paginate(15));
    }
    // Check if order is from Auth user_id
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function payment(PaymentOrderRequest $request)
    {
        if(!Auth::user()->getIsCustomer()){
            return response()->json(['message' => 'Your user cannot create orders'], 401);
        }
        $customerId = Auth::user()->customer->id;
        $total_order = 0;
        $points_discount = 0;
        $points_used = 0;

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
        if($request->checkout['points'] > 0){
            if($request->checkout['points'] > Auth::user()->customer->points){
                return response()->json(['message' => 'You are using more points then the ones you have'], 400);
            }
            if(($request->checkout['points'] % 10) == 0){
                $points_used = $request->checkout['points'];
                $points_discount = ($request->checkout['points'] / 2);
            }
        }
        $total_order_paying = $total_order - $points_discount;
        $points_gained = floor($total_order / 10);

        $utils = new Utils();
        // check if the values are valid for payment
        if(!$utils->checkPayment($request->checkout['pay_type'], $request->checkout['pay_reference'], $total_order_paying)){
            return response()->json(['message' => 'The payment values are not valid'], 400);
        }
        // call the payment server
        if(!$utils->callPaymentGateway($request->checkout['pay_type'], $request->checkout['pay_reference'], $total_order_paying)){
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
            'total_paid'                => $total_order_paying,
            'total_paid_with_points'    => $points_discount,
            'points_gained'             => $points_gained,
            'points_used_to_pay'        => $points_used,
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

    private function refund(Order $order)
    {
        $utils = new Utils();
        // call the payment server
        if(!$utils->callPaymentGateway($order->payment_type, $order->payment_reference, $order->total_paid, true)){
            return false;
        }
        if($order->customer_id != null) {
            if ($order->total_paid_with_points > 0) {
                Customer::where('id', $order->customer_id)->increment('points', ($order->total_paid_with_points * 2));
            }
            if ($order->points_gained > 0) {
                Customer::where('id', $order->customer_id)->decrement('points', $order->points_gained);
            }
        }
        return true;
    }

    public function update(StoreUpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        return new OrderResource($order);
    }

    public function destroy(Order $order)
    {
        $oldStatus = $order->status;
        if($oldStatus != 'C' && $oldStatus != 'D'){
            $refundOperation = $this->refund($order);
            if(!$refundOperation){
                return response()->json(['message' => 'The payment values are not valid by the payment server'], 400);
            }
            $order->status = "C";
            $order->updated_at = Carbon::now();
            $order->save();
            return response()->json(['message' => 'Order refunded and status changed to Cancel.']);
        }
        return response()->json(['message' => 'Order not found'], 403);
    }


    // Requests for the kitchen
    public function getActiveOrders(){
        return OrderKitchenResource::collection(Order::where([['status', '!=', 'D'], ['status', '!=', 'C']])->orderBy('created_at')->get());
    }

    public function getOrderStatus(Order $order){

        //Passar os status da order
        return new OrderStatusResource($order);
    }

    public function setOrderItemStatus(OrderItem $orderItem)
    {
        if(!Auth::hasUser() || Auth::user()->getIsCustomer()){
            return response()->json(["message" => 'You dont have permissions to change the order item'], 401);
        }

        if($orderItem->product->type == "hot dish") {
            if(Auth::user()->type == "EC") {
                $orderItem->status = ($orderItem->status == "W" ? "P" : "R");
                $orderItem->preparation_by = Auth::user()->id;
                $orderItem->save();
            } else {
                return response()->json(["message" => 'You dont have the role of Chef to change the order item'], 401);
            }
        } else {
            return response()->json(["message" => 'You dont have permissions to change the order item'], 401);
        }
        $order = Order::find($orderItem->order_id);
        $allReady = true;
        foreach ($order->orderItems as $item){
            if($item->status != "R") {
                $allReady = false;
            }
        }
        if($allReady) {
            $order->status = "R";
            $order->updated_at = Carbon::now();
            $order->save();
        }
        return response()->json([
            "order_status" => $order->status,
            "item_status" => $orderItem->status
        ]);
    }

    public function setOrderStatus(Order $order)
    {
        if(!Auth::hasUser() || Auth::user()->getIsCustomer()){
            return response()->json(["message" => 'You dont have permissions to change the order'], 401);
        }
        if(Auth::user()->type == "ED") {
            $order->status = ($order->status == "R" ? "D" : "R");
            $order->delivered_by = Auth::user()->id;
            $order->updated_at = Carbon::now();
            $order->save();
        } else {
            return response()->json(["message" => 'You dont have the role of Delivery to change the order item'], 401);
        }
        return response()->json([
            "order_status" => $order->status
        ]);
    }




    public function getOrdersOfProduct(Request $request, Product $product)
    {
        //OrderResource::$format = 'detailed';
        if (!$request->has('include_assigned')) {
            return OrderResource::collection($product->Orders->orderBy('id', 'desc'));
        } else {
            return OrderResource::collection($product->Orders->merge($product->assigedOrders)->orderBy('id', 'desc'));
        }
    }
    // TODO Check from here down

    public function getStatus($status){
        switch(strtoupper($status)){
            case 'H':
            case 'P':
            case 'R':
            case 'T':
            case 'D':
            case 'C':
                return OrderResource::collection(Order::where('status', '=', $status)->get())->orderBy('current_status_at', 'desc')->values()->all();
        }

        return response()->json(['message' => 'The status ' . strtoupper($status) . ' does not exist'], 404);
    }
}
