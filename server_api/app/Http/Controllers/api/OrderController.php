<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentOrderRequest;
use App\Http\Resources\OrderDetailResource;
use App\Http\Resources\OrderResource;
use App\Models\Customer;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{

    public function index()
    {
        if(Auth::user()->getIsCustomer()){
            $orders = Order::where('customer_id', Auth::user()->customer->id);
        } else {
            $orders = Order::whereNotNull('customer_id');
        }
        return OrderResource::collection($orders->paginate(15));
    }
    // Check if order is from Auth user_id
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function payment(PaymentOrderRequest $request, Order $order)
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
            if(($request->checkout['points'] % 10) == 0){
                $points_used = $request->checkout['points'];
                $points_discount = ($request->checkout['points'] / 2);
            }
        }
        $total_order_paying = $total_order - $points_discount;
        $points_gained = floor($total_order / 10);

        // check if the values are valid for payment
        if(!$this->checkPayment($request->checkout['pay_type'], $request->checkout['pay_reference'], $total_order_paying)){
            return response()->json(['message' => 'The payment values are not valid'], 400);
        }
        // call the payment server
        if(!$this->callPaymentGateway($request->checkout['pay_type'], $request->checkout['pay_reference'], $total_order_paying)){
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

    public function refund(Order $order)
    {
        // call the payment server
        if(!$this->callPaymentGateway($order->payment_type, $order->payment_reference, $order->total_paid, true)){
            return response()->json(['message' => 'The payment values are not valid by the payment server'], 400);
        }
        if($order->total_paid_with_points > 0) {
            Customer::where('id', $order->customer_id)->increment('points', ($order->total_paid_with_points * 2));
        }
        if($order->points_gained > 0) {
            Customer::where('id', $order->customer_id)->increment('decrement', $order->points_gained);
        }

        return new OrderResource($order);
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


    // Requests for the kitchen
    public function getActiveOrders(){
        return OrderResource::collection(Order::where([['status', '!=', 'D'], ['status', '!=', 'C']])->get());
    }

    public function getOrderStatus(Order $order){

        //Passar os status da order
        return new OrderStatusResource($order);
    }

    public function setOrderStatus(Order $order){

        //Passar os status da order
        return new OrderStatusResource($order);
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
    // TODO Check from here down

    public function getStatus($status){
        switch(strtoupper($status)){
            case 'H':
            case 'P':
            case 'R':
            case 'T':
            case 'D':
            case 'C':
                return OrderResource::collection(Order::where('status', '=', $status)->get())->sortBy('current_status_at')->values()->all();
        }

        return response()->json(['message' => 'The status ' . strtoupper($status) . ' does not exist'], 404);
    }



    public function getOrderById($id){
        return OrderResource::collection(Order::where('id', '=', $id)->get());
    }

    public function setOrderStatus_old($id, $status){
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $status = strtoupper($status);

        switch($status){
            case 'H':
                $order->opened_at = Carbon::now();
                break;
            case 'P':
                $order->prepared_by = Auth::user()->id;
                Auth::user()->available_at = null;
                Auth::user()->save();
                break;
            case 'R':
                $order->preparation_time = Carbon::now()->diffInSeconds($order->current_status_at);
                Auth::user()->available_at = Carbon::now();
                Auth::user()->save();
                break;
            case 'T':
                $order->delivered_by = Auth::user()->id;
                Auth::user()->available_at = null;
                Auth::user()->save();
                break;
            case 'D':
                $order->delivery_time = Carbon::now()->diffInSeconds($order->current_status_at);
                $order->total_time = Carbon::now()->diffInSeconds($order->opened_at);
                $order->closed_at = Carbon::now();

                Auth::user()->available_at = Carbon::now();
                Auth::user()->save();
                break;
            case 'C':
                if($order->status == 'T'){
                    $user = User::findOrFail($order->delivered_by);
                    $user->available_at = Carbon::now();
                    $user->save();

                    $order->delivered_by = null;
                }else if($order->status == 'P'){
                    $user = User::findOrFail($order->prepared_by);
                    $user->available_at = Carbon::now();
                    $user->save();

                    $order->prepared_by = null;
                }

                $order->total_time = Carbon::now()->diffInSeconds($order->opened_at);
                $order->closed_at = Carbon::now();
                break;
            default:
                return response()->json('Status ' . $status . ' doesn\'t exist', 404);
        }

        $order->current_status_at = Carbon::now();
        $order->status = $status;
        $order->save();

        return response()->json(['message' => 'Order status updated. Order went from '. $oldStatus . ' to ' . $order->status, 'order' => new OrderResource($order)], 200);
    }

    private function callPaymentGateway($pay_type, $pay_reference, $order_value, $isRefund = false)
    {
        $url = 'https://dad-202223-payments-api.vercel.app';
        if($isRefund){
            $url = $url . '/api/refunds';
        } else {
            $url = $url . '/api/payments';
        }
        $response = Http::post($url, [
            "type"      => $pay_type,
            "reference" => $pay_reference,
            "value"     => $order_value
        ]);

        if ($response->status() == 201) {
            return true;
        }
        return false;
    }

    private function checkPayment($pay_type, $pay_reference, $order_value)
    {
        $paymentValid = false;
        $pay_type = strtolower($pay_type);
        if ($pay_type === "visa") { // for a Visa payment is the Visa Card ID with 16 digits;
            // Test visa
            $paymentValid = preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $pay_reference);
            if(!$paymentValid){
                // Test visaMaster
                $paymentValid = preg_match('/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14})$/', $pay_reference);
            }
            $paymentValid = $paymentValid && $order_value < 200;
        } else if ($pay_type === "paypal") { // the reference for the PayPal is a valid email
            $paymentValid = filter_var($pay_reference, FILTER_VALIDATE_EMAIL) && preg_match('/\.(pt|com)$/', $pay_reference);
            $paymentValid = $paymentValid && $order_value < 50;
        } else if ($pay_type === "mbway") { // the reference for the MbWay is the mobile phone number with 9 digits
            $paymentValid =  preg_match('/^(9)[0-9]{8}$/', $pay_reference);
            $paymentValid = $paymentValid && $order_value < 10;
		}
        return $paymentValid;
    }
}
