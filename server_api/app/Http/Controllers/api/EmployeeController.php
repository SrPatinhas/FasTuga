<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\TopProductResource;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeController extends Controller
{
    public function index()
    {
        $usersList = User::where('type', '<>', 'C')->paginate(15);
        return UserResource::collection($usersList);
    }

    public function create(CreateEmployeeRequest $request)
    {
        $photo = null;
        if($request->hasFile('photo')){
            $photo = $this->uploadPhoto($request);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'blocked' => false,
            'photo_url' => $photo
        ]);

        return new UserResource($user);
    }

    public function show(User $user)
    {
        //return EmployeeResource::collection($employee->users);
        return new EmployeeResource($user);

    }


    public function update(UpdateUserRequest $request, User $user)
    {
        //So menager pode
        if(Auth::user()->type == 'EM' || Auth::user()->id == $user->id) {
            if($request->hasFile('photo')){
                $photo = $this->uploadPhoto($request);
                $user->update(['photo_url' => $photo]);
            }
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
                'type'  => $request->type
            ]);
            $user->save();
            return new UserResource($user);
        }
        return response()->json(['message' => 'You are not Manager or the owner of the user'], 403);
    }



    public function destroy(User $user)
    {
        if(User::where("id", $user->id)->exists()) {
        User::where("id", $user->id)->delete();
        return new UserResource($user);
        }
        return response()->json(['message' => 'User not found'], 403);

    }

    public function getEmployees(){
        return UserResource::collection(User::where('type', '!=', 'C')->get());
    }

    public function getCurrentOrder(User $user){
        if($user->type == 'EC'){
            return OrderResource::collection(Order::where([['status', '=', 'P'], ['prepared_by', '=', $user->id]])->get());
        }else if($user->type == 'ED'){
            return OrderResource::collection(Order::where([['status', '=', 'T'], ['delivered_by', '=', $user->id]])->get());
        }
        return response()->json(['message' => 'Type not found'], 404);
    }


    private function uploadPhoto(Request $request){
        $request->validate(['photo' => 'nullable|image|mimes:jpeg,png,jpg']);
        Storage::putFile('public/fotos', $request->file('photo'));
        return  $request->file('photo')->hashName();
    }


    public function sidebarCounts()
    {
        if(Auth::user()->type == 'EM') {
            $monthReveneu   = Order::whereMonth('date', Carbon::now()->month)->where('status', '<>', 'C')->sum('total_paid');
            $clients        = Customer::count();
            $employees      = User::where('type', '<>', 'C')->count();
            $products       = Product::count();
            $orders         = Order::count();

            return response()->json([
                'dashboard' => (float) $monthReveneu,
                'clients'   => (int) $clients,
                'employees' => (int) $employees,
                'products'  => (int) $products,
                'orders'    => (int) $orders
            ]);
        }
    }

    public function statistic()
    {
        if(Auth::user()->type == 'EM') {
            $monthReveneu   = Order::whereMonth('date', Carbon::now()->month)->where('status', '<>', 'C')->sum('total_paid');

            $ordersThisMonth = Order::whereDate('created_at', '>=', Carbon::now()->startOfMonth())
                                    ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
                                    ->count();

            $orderItems     = Order::whereDate('created_at', '>=', Carbon::now()->startOfMonth())
                                ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
                                ->join('order_items', 'order_items.order_id', 'orders.id')
                                ->withCount('orderItems')
                                ->sum('order_items.product_quantity');
            $graph = [];
            //$graph = Order::selectRaw('YEAR(created_at) year, MONTH(created_at) month, SUM(total_paid) as total_paid')
            //                ->whereBetween('created_at', [Carbon::now()->subYear(), Carbon::now()])
            //                ->groupBy('year', 'month')
            //                ->pluck('total_paid', 'month')->toArray();
            $graph = Order::selectRaw('YEAR(created_at) year, WEEK(created_at) week, SUM(total_paid) as total_paid')
                            ->whereBetween('created_at',[Carbon::now()->subWeeks(6), Carbon::now()])
                            ->groupBy('year', 'week')
                            ->pluck('total_paid', 'week')->toArray();
            $weeks = [];

            for ($i = 5; $i >= 0; $i--) {
                $weekStart = date('Y-m-d', strtotime("-$i week"));
                $weekNumber = date_format(date_create_from_format('Y-m-d', $weekStart), 'W');

                $value = 0;
                if(array_key_exists($weekNumber, $graph)){
                    $value = $graph[$weekNumber];
                }
                $weeks[] = (int) $value;
            }

            $topItems = Product::join('order_items', 'order_items.product_id', '=', 'products.id')
                            ->join('orders', 'orders.id', '=', 'order_items.order_id')
                            ->select('products.*', DB::raw('SUM(order_items.product_quantity) as total_quantity'))
                            ->groupBy('products.id')
                            ->orderBy('total_quantity', 'desc')
                            ->get()
                            ->take(5);


            return response()->json([
                'graph'         => $weeks,//$graph,
                'monthReveneu'  => (float) $monthReveneu,
                'orders'        => (int) $ordersThisMonth,
                'orderItems'    => (int) $orderItems,
                'topItems'      => TopProductResource::collection($topItems)
            ]);
        }
    }
}
