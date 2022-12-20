<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\LastOrdersResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\TopProductResource;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{

    public function index(){
        return CustomerResource::collection(Customer::paginate(15));
    }

    public function customerInfo(){
        $customerId = Auth::user()->customer->id;
        $customer = Customer::findOrFail($customerId);
        return new CustomerResource($customer);
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
        $orders = Order::where('customer_id', '=', $customer->id)->sortByDesc('id')->get();
        return OrderResource::collection($orders);
    }


    public function update(UpdateCustomerRequest $request, $id)
    {
        $user = new User;
        $customer = new Customer;

        $user = User::findOrFail($id);
        $userBackUp = User::findOrFail($id);
        $customer = Customer::findOrFail($id);

        $user->type = 'C';

        $user->fill($request->validated());

        if($request->password == null){
            $value = 0;
            $user->password = $userBackUp->password;
        }else{
            $value = 1;
            $user->password = Hash::make($request->password);
        }
        try{
            $customer->fill($request->validated());
            $customer->save();
        }catch(\Throwable $error){
            $user->getOriginal();
        }
        $user->save();
        return response()->json(['User updated successfully. ' . $user, 201]);
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
        $customerId = Auth::user()->customer->id;
        $lastOrders = Order::where('customer_id', $customerId)->latest()->take(3)->get();
        return LastOrdersResource::collection($lastOrders);
    }

}
