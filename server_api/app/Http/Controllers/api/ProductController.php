<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(StoreUpdateProductRequest $request)
    {
        $newProduct = Product::create($request->validated());
        return new ProductResource($newProduct);
    }

    public function update(StoreUpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        Product::where("product_id", $product->id)->delete();
        $product->delete();
        return new ProductResource($product);
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

    public function getTopHotItems(){
        return $this->topItemsByCategory('hot dish', 4);
    }
    public function getTopColdItems(){
        return $this->topItemsByCategory('cold dish', 4);
    }
    public function getTopDessertItems(){
        return $this->topItemsByCategory('dessert', 4);
    }  
}
