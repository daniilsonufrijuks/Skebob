<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard(): \Inertia\Response
    {
        $orders = Order::select([
            'id', 'user_id', 'status', 'total_price', 'shipping_address',
            'ordered_at', 'created_at', 'updated_at'
            ])->latest()->get();

        $products = Product::select([
            'id', 'name', 'price', 'amount_value', 'amount_unit', 'country_origin',
            'image', 'ingredients', 'nutritional_info', 'storage_conditions',
            'admin_id', 'brand_id', 'category_id', 'created_at', 'updated_at'
            ])->latest()->get();

        $orderItems = OrderItem::with(['order', 'product'])
            ->select([
                'id', 'quantity', 'unit-price', 'subtotal', 'order_id', 'product_id',
                'created_at', 'updated_at'
            ])->latest()->get();

        $users = User::select([
            'id', 'name', 'email', 'has_subscription', 'created_at', 'updated_at'
            ])->latest()->get();

        $brands = Brand::select([
            'id', 'name', 'created_at', 'updated_at'
        ])->latest()->get();

        return Inertia::render('Admin', [
            'orders' => $orders,
            'products' => $products,
            'orderItems' => $orderItems,
            'users' => $users,
            'brands' => $brands,
        ]);
    }

    public function showOrders(Request $request): \Illuminate\Http\JsonResponse
    {
        $orders = Order::select([
            'id', 'user_id', 'status', 'total_price', 'shipping_address',
            'ordered_at', 'created_at', 'updated_at'
        ])->latest()->get();

        return response()->json($orders);
    }

    public function showProducts(Request $request): \Illuminate\Http\JsonResponse
    {
        $products = Product::select([
            'id', 'name', 'price', 'amount_value', 'amount_unit', 'country_origin',
            'image', 'ingredients', 'nutritional_info', 'storage_conditions',
            'created_at', 'updated_at'
        ])->latest()->get();

        return response()->json($products);
    }

    public function showOrderItems(Request $request): \Illuminate\Http\JsonResponse
    {
        $orderItems = OrderItem::with(['order', 'product'])
            ->select([
                'id', 'quantity', 'unit-price', 'subtotal', 'order_id', 'product_id',
                'created_at', 'updated_at'
            ])
            ->latest()
            ->get();

        return response()->json($orderItems);
    }

    public function showUsers(Request $request): \Illuminate\Http\JsonResponse
    {
        $users = User::select([
            'id', 'name', 'email', 'has_subscription', 'created_at', 'updated_at'
        ])->latest()->get();

        return response()->json($users);
    }

    public function showBrands(Request $request): \Illuminate\Http\JsonResponse
    {
        $brands = Brand::select([
            'id', 'name', 'created_at', 'updated_at'
        ])->latest()->get();

        return response()->json($brands);
    }

    public function storeBrand(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
        ]);

        try {
            Brand::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'admin_id' => 1,
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Brand added successfully!');

        } catch (\Exception $e) {
            \Log::error('Error adding brand: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add brand: ' . $e->getMessage());
        }
    }

    public function storeProduct(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'amount_value' => 'required|numeric|min:0',
            'amount_unit' => 'required|in:g,kg,ml,l,gab',
            'country_origin' => 'nullable|string|max:100',
            'ingredients' => 'nullable|string',
            'nutritional_info' => 'nullable|string',
            'storage_conditions' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/front'), $imageName);
                $imagePath = 'images/front/' . $imageName;
            }

            Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'price' => $request->price,
                'amount_value' => $request->amount_value,
                'amount_unit' => $request->amount_unit,
                'country_origin' => $request->country_origin,
                'image' => $imagePath,
                'ingredients' => $request->ingredients,
                'nutritional_info' => $request->nutritional_info,
                'storage_conditions' => $request->storage_conditions,
                'admin_id' => 1, // Default admin ID
                'brand_id' => 1, // Default brand ID
                'category_id' => 1, // Default category ID
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Product added successfully!');

        } catch (\Exception $e) {
            \Log::error('Error adding product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add product: ' . $e->getMessage());
        }
    }

    public function destroyProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $product->delete();

            return response()->json(['success' => 'Product deleted successfully!']);

        } catch (\Exception $e) {
            \Log::error('Error deleting product: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete product.'], 500);
        }
    }

    public function destroyOrder($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return response()->json(['success' => 'Order deleted successfully!']);
        } catch (\Exception $e) {
            \Log::error('Error deleting order: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete order.'], 500);
        }
    }

    public function destroyOrderItem($id)
    {
        try {
            $orderItem = OrderItem::findOrFail($id);
            $orderItem->delete();
            return response()->json(['success' => 'Order item deleted successfully!']);
        } catch (\Exception $e) {
            \Log::error('Error deleting order item: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete order item.'], 500);
        }
    }

    public function destroyUser($id)
    {
        try {
            $user = User::findOrFail($id);

            // check if user has orders before deleting
            if ($user->orders()->exists()) {
                return response()->json(['error' => 'Cannot delete user with existing orders.'], 400);
            }

            $user->delete();
            return response()->json(['success' => 'User deleted successfully!']);
        } catch (\Exception $e) {
            \Log::error('Error deleting user: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete user.'], 500);
        }
    }

    public function destroyBrand($id)
    {
        try {
            $brand = Brand::findOrFail($id);

            // check if brand has products before deleting
            if ($brand->products()->exists()) {
                return response()->json(['error' => 'Cannot delete brand with existing products.'], 400);
            }

            $brand->delete();
            return response()->json(['success' => 'Brand deleted successfully!']);
        } catch (\Exception $e) {
            \Log::error('Error deleting brand: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete brand.'], 500);
        }
    }

    public function updateProduct(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        Log::info('Update product request received', ['id' => $id, 'data' => $request->all()]);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'amount_value' => 'required|numeric|min:0',
            'amount_unit' => 'required|in:g,kg,ml,l,gab',
            'country_origin' => 'nullable|string|max:100',
            'ingredients' => 'nullable|string',
            'nutritional_info' => 'nullable|string',
            'storage_conditions' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $product = Product::findOrFail($id);
            Log::info('Product found', ['product' => $product->toArray()]);

            $updateData = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'price' => $request->price,
                'amount_value' => $request->amount_value,
                'amount_unit' => $request->amount_unit,
                'country_origin' => $request->country_origin,
                'ingredients' => $request->ingredients,
                'nutritional_info' => $request->nutritional_info,
                'storage_conditions' => $request->storage_conditions,
            ];

            Log::info('Update data prepared', $updateData);

            // Handle new image upload
            if ($request->hasFile('image')) {
                Log::info('New image uploaded');

                // Delete old image if exists
                if ($product->image && file_exists(public_path($product->image))) {
                    Log::info('Deleting old image', ['path' => $product->image]);
                    unlink(public_path($product->image));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/front'), $imageName);
                $updateData['image'] = 'images/front/' . $imageName;

                Log::info('New image saved', ['path' => $updateData['image']]);
            }

            $updated = $product->update($updateData);
            Log::info('Product update result', ['updated' => $updated, 'product_after' => $product->fresh()->toArray()]);

            if ($updated) {
                return redirect()->route('admin.dashboard')->with('success', 'Product updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to update product in database.');
            }

        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }
}
