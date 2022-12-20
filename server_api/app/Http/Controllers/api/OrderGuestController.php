<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderStatusResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderGuestController extends Controller
{

    public function index()
    {
        // Filter by Auth user_id
        return OrderResource::collection(Order::whereNotNull('customer_id')->get());
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

    //ORDERGUESTCONTROLLER aquii
    public function paymentGuest(){
        
    }

    public function showGuest (Order $order){

        return new OrderResource($order);
    }

    public function getOrderStatusGuest(Order $order){

        //Passar os statusOrder
        return new OrderStatusResource($order);   
    }

    //por fazer
    public function getBoardItems (Order $order){

        return new OrderStatusResource($order);
    }

//ate aqui

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

    public function setOrderStatus($id, $status){
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

    public function getActiveOrders(){
        return OrderResource::collection(Order::where([['status', '!=', 'D'], ['status', '!=', 'C']])->get());
    }

    public function create(CreateOrderRequest $request){

        $order = new Order;

        $current_date = Carbon::now()->toDateString();
        $current_date_time = Carbon::now()->toDateTimeString();

        $order->status = 'H';

        $order->date = $current_date;
        $order->opened_at = $current_date_time;
        $order->current_status_at = $current_date_time;

        $order->fill($request->validated());

        $order->save();

        $productsList = $request->products;
        $size = count($productsList);

        $orderTotalPrice = 0;

        for ($i=0; $i < $size; $i++) {

            $product = Product::findOrFail($productsList[$i]["id"]);

            if($product->price != $productsList[$i]["price"]){
                return response()->json(['message' => 'Price of the product dont match'], 400);
            }

            $productTotalPrice = $product->price * $productsList[$i]["quantity"];

            if ($productTotalPrice != $productsList[$i]["totalPrice"]) {
                return response()->json(['message' => 'Price of the product dont match'], 400);
            }

            $orderTotalPrice += $productTotalPrice;

            $orderItem = new OrderItem();

            $orderItem->order_id = $order->id;
            $orderItem->product_id = $productsList[$i]["id"];
            $orderItem->quantity = $productsList[$i]["quantity"];
            $orderItem->unit_price = $productsList[$i]["price"];
            $orderItem->sub_total_price = $productsList[$i]["totalPrice"];

            $orderItem->save();

        };

        $orderTotalPrice = round($orderTotalPrice, 2);

        if ($orderTotalPrice != (float)$order->total_price) {
            $order->status = 'C';
            $order->save();
            return response()->json(['message' => 'Price of the order dont match'], 403);
        }

        return response()->json(['message' => 'Order created successfully.', 'order' => new OrderResource($order)], 200);
    }
}
