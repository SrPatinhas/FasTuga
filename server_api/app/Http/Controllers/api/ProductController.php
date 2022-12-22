<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductManagerResource;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreUpdateProductRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::all());
    }
    public function list()
    {
        return ProductManagerResource::collection(Product::paginate(15));
    }


    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(StoreUpdateProductRequest $request)
    {

        $photo = null;
        if($request->hasFile('photo')){
            $photo = $this->uploadPhoto($request);
        }
        $newProduct = Product::create([
            'name' => $request->name,
            'type' => str_replace('_', ' ', $request->type),
            'description' => $request->description,
            'photo_url' => $photo,
            'price' => $request->price
        ]);
        return new ProductResource($newProduct);
    }

    public function update(StoreUpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        if(Product::where("id", $product->id)->exists()) {
        Product::where("id", $product->id)->delete();
        return new ProductResource($product);
        }
        return response()->json(['message' => 'Product not found'], 403);
    }

    public function update_completed(UpdateCompleteProductRequest $request, Product $product)
    {
        $product->completed = $request->validated()['completed'];
        $product->save();
        return new ProductResource($product);
    }

    public function getOrdersOfProduct(Product $product)
    {
        $orders = Order::leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('order_items.product_id', '=', $product->id)
            ->get();

        return OrderResource::collection($orders);
    }


    public function trending(){
        $mostUsedProduct = Product::select('products.*', DB::raw('count(order_items.product_id) as times_ordered'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereNotIn('products.type', ['drink'])
            ->where('orders.created_at', '>=', Carbon::now()->subMonths(3))//Hours(24))
            ->groupBy('products.id')
            ->orderBy('times_ordered', 'desc')
            ->limit(8)
            ->get();

        return ProductResource::collection($mostUsedProduct);
    }


    private function uploadPhoto(Request $request){
        $request->validate(['photo' => 'nullable|image|mimes:jpeg,png,jpg']);
        Storage::putFile('public/products', $request->file('photo'));
        return  $request->file('photo')->hashName();
    }

//Manager stats
private function topItemsByCategory($category, $page){
    $mostUsedProduct = Product::select('products.*', DB::raw('count(order_items.product_id) as times_ordered'))
        ->join('order_items', 'products.id', '=', 'order_items.product_id')
        ->join('orders', 'orders.id', '=', 'order_items.order_id')
        ->whereIn('products.type', [$category])
        ->where('orders.created_at', '>=', Carbon::now()->subMonths(3))//Hours(24))
        ->groupBy('products.id')
        ->orderBy('times_ordered', 'desc')
        ->limit($page)
        ->get();

    return ProductResource::collection($mostUsedProduct);
}
    /*
    public function getTopHotItems(){
        return $this->topItemsByCategory('hot dish', 4);
    }
    public function getTopColdItems(){
        return $this->topItemsByCategory('cold dish', 4);
    }
    public function getTopDessertItems(){
        return $this->topItemsByCategory('dessert', 4);
    }*/

    public function getTopItems(){

        $hotDish =  $this->topItemsByCategory('hot dish', 4);
        $coldDish =  $this->topItemsByCategory('cold dish', 4);
        $dessert =  $this->topItemsByCategory('dessert', 4);

        return response()->json(['hot dish' => $hotDish, 'cold dish' => $coldDish , 'dessert' => $dessert]);

    }


}

