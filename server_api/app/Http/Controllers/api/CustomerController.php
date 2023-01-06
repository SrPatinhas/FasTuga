<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\LastOrdersResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\TopProductResource;
use App\Http\Resources\UserResource;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{

    public function index()
    {
        return CustomerResource::collection(Customer::paginate(15));
    }

    public function customerInfo()
    {
        if(Auth::user()->type == 'C'){
            $customerId = Auth::user()->customer->id;
            $customer = Customer::findOrFail($customerId);
                return new CustomerResource($customer);
        }
        return response()->json(['Customer not found', 400]);
    }

    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    public function orderDetails(Customer $customer,Order $order)
    {
        if($order->customer_id = $customer->id) {
            return new OrderResource($order);
        }
        return response()->json(['The requested order does not belongs to the requested customer', 400]);
    }

    public function customerOrders(Customer $customer){
        $orders = Order::where('customer_id', '=', $customer->id)->orderBy('id', 'desc')->get();
        return OrderResource::collection($orders);
    }



    public function uploadPhoto(Request $request){
        $request->validate(['photo_file' => 'nullable|image|mimes:jpeg,png,jpg']);

        $path = Storage::putFile('public/fotos', $request->file('photo_file'));

        return response()->json(['location' => '/storage/fotos/'.$request->file('photo_file')->hashName(), 'filename' => $request->file('photo_file')->hashName()], 201);
    }




    public function getCurrentOrder(User $user){
        if($user->type == 'EC'){
            return OrderResource::collection(Order::where([['status', '=', 'P'], ['prepared_by', '=', $user->id]])->get());
        }else if($user->type == 'ED'){
            return OrderResource::collection(Order::where([['status', '=', 'T'], ['delivered_by', '=', $user->id]])->get());
        }
        return response()->json(['message' => 'Type not found'], 404);
    }


    public function topProducts(){
        $customerId = Auth::user()->customer->id;
        $items = Product::join('order_items', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.customer_id', $customerId)
            ->select('products.*', DB::raw('SUM(order_items.product_quantity) as total_quantity'))
            ->groupBy('products.id')
            ->orderBy('total_quantity', 'desc')
            ->get()
            ->take(4);

        return TopProductResource::collection($items);
    }

    public function lastOrders(){
        if(Auth::user()->type != 'C') {
            return response()->json(['message' => 'Type not found'], 404);
        }
        $customerId = Auth::user()->customer->id;

        $lastOrders = Order::where('customer_id', $customerId)->latest()->limit(3)->get();
        return LastOrdersResource::collection($lastOrders);
    }

}
