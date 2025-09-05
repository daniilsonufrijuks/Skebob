<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard(): \Inertia\Response
    {
        $orders = Orders::with('user')->get(); // Existing

        $products = Products::select(['id', 'name', 'price', 'description', 'image', 'category'])->get();

        $ordersj = Orders::join('users', 'orders.user_id', '=', 'users.id')
            ->join('goods_orders', 'orders.id', '=', 'goods_orders.order_id')
            ->select(
                'orders.id as order_id',
                'orders.status as order_status',
                'orders.total',
                'orders.created_at',
                'users.name as customer_name',
                'users.email as customer_email',
                'goods_orders.name as item_name',
                'goods_orders.price as item_price',
                'goods_orders.status as item_status',
                'goods_orders.category',
                'goods_orders.total_price'
            )
            ->get();

        return Inertia::render('Admin', [
            'orders' => $orders,
            'products' => $products,
            'ordersj' => $ordersj
        ]);
    }





    public function showOrders(Request $request): \Illuminate\Http\JsonResponse
    {
//        $orders = Orders::all(); // Fetch all orders
//        return Inertia::render('AdminOrders', ['orders' => $orders]);
        //global $request;

        // Fetch the filtered results
//        $orders = Orders::select(['id', 'user_id', 'items', 'status', 'total', 'created_at'])->get();
        $orders = Orders::with(['orderGoods', 'user:id,name,email']) // add any user fields you need
        ->select(['id', 'user_id', 'status', 'total', 'ordered_at', 'created_at'])
            ->get();

        return response()->json($orders);
    }

    public function showProducts(Request $request): \Illuminate\Http\JsonResponse
    {
        $products = Products::select(['name', 'price', 'description', 'image', 'category'])->get();
        return response()->json($products);
    }

    public function storeProduct(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|string|max:255',
        ]);

//        if (!$request->hasFile('image')) {
//            return redirect()->back()->withErrors(['image' => 'Image is required']);
//        }
//
//        $imagePath = $request->file('image')->store('products', 'public');
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/front'), $imageName);
            $imagePath = 'images/front/' . $imageName; // Store the correct relative path in DB
        }

//        Products::create([
//            'name' => $request->name,
//            'price' => $request->price,
//            'description' => $request->description,
//            'image' => $imagePath,
//            'category' => $request->category,
//        ]);
        try {
            Products::create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'image' => $imagePath,
                'category' => $request->category,
                'admin_id' => auth('admin')->id(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error adding product: ' . $e->getMessage());
        }


        // Redirect to the products page
        return redirect()->route('admin.dashboard')->with('success', 'Product added successfully!');
    }

    public function showjoinedOrders(): \Illuminate\Http\JsonResponse
    {
//        $orders = Orders::with('user')->get();
//
//        return response()->json($orders);
//        $orders = Orders::join('users', 'orders.user_id', '=', 'users.id')
//            ->select(
//                'orders.id',
//                'orders.items',
//                'orders.status',
//                'orders.total',
//                'orders.created_at',
//                'users.name as customer_name',
//                'users.email as customer_email'
//            )
//            ->get();
        $orders = Orders::join('users', 'orders.user_id', '=', 'users.id')
            ->join('goods_orders', 'orders.id', '=', 'goods_orders.order_id')
            ->select(
                'orders.id as order_id',
                'orders.status as order_status',
                'orders.total',
                'orders.created_at',
                'users.name as customer_name',
                'users.email as customer_email',
                'goods_orders.name as item_name',
                'goods_orders.price as item_price',
                'goods_orders.status as item_status',
                'goods_orders.category',
                'goods_orders.total_price'
            )
            ->get();


        return response()->json($orders);
    }

    public function destroyProduct($id) {
        Products::findOrFail($id)->delete();
        return redirect()->back();
    }
    public function destroyOrder($id) {
        Orders::findOrFail($id)->delete();
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        $product->update($request->only('name', 'price', 'category', 'description'));

        return redirect()->back();
    }
}
