<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MysteryBox;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function getChipsProducts(Request $request): \Illuminate\Http\JsonResponse
    {

        //global $request;
        $query = Product::where('category_id', '1');

        // Apply filters based on query parameters
        // Handle price_min only if not null
        // Check if price_min is provided
        // Apply filters only if values are not null or empty
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        // Fetch the filtered results
        $products = $query->get(['id', 'name', 'price', 'ingredients', 'image']);

        return response()->json($products);
    }

    public function getChocolatesProducts(Request $request): \Illuminate\Http\JsonResponse
    {
        //global $request;
        $query = Product::where('category_id', '2');

        // Apply filters based on query parameters
        // Handle price_min only if not null
        // Check if price_min is provided
        // Apply filters only if values are not null or empty
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        // Fetch the filtered results
        $products = $query->get(['id', 'name', 'price', 'ingredients', 'image']);

        return response()->json($products);
    }

    public function getDrinksProducts(Request $request): \Illuminate\Http\JsonResponse
    {
        //global $request;
        $query = Product::where('category_id', '3');

        // Apply filters based on query parameters
        // Handle price_min only if not null
        // Check if price_min is provided
        // Apply filters only if values are not null or empty
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        // Fetch the filtered results
        $products = $query->get(['id', 'name', 'price', 'ingredients', 'image']);

        return response()->json($products);
    }

//     for phones
    public function getNutsProducts(Request $request): \Illuminate\Http\JsonResponse
    {
        //global $request;
        $query = Product::where('category_id', '4');

        // Apply filters based on query parameters
        // Handle price_min only if not null
        // Check if price_min is provided
        // Apply filters only if values are not null or empty
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        // Fetch the filtered results
        $products = $query->get(['id', 'name', 'price', 'ingredients', 'image']);

        return response()->json($products);
    }

//    for periph
    public function getBiscuitsProducts(Request $request): \Illuminate\Http\JsonResponse
    {
        //global $request;
        $query = Product::where('category_id', '5');

        // Apply filters based on query parameters
        // Handle price_min only if not null
        // Check if price_min is provided
        // Apply filters only if values are not null or empty
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        // Fetch the filtered results
        $products = $query->get(['id', 'name', 'price', 'ingredients', 'image']);

        return response()->json($products);
    }

    public function getFruitsnacksProducts(Request $request): \Illuminate\Http\JsonResponse
    {
        //global $request;
        $query = Product::where('category_id', '6');

        // Apply filters based on query parameters
        // Handle price_min only if not null
        // Check if price_min is provided
        // Apply filters only if values are not null or empty
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        // Fetch the filtered results
        $products = $query->get(['id', 'name', 'price', 'ingredients', 'image']);

        return response()->json($products);
    }


//    for cables
    public function getCandyProducts(Request $request): \Illuminate\Http\JsonResponse
    {
        //global $request;
        $query = Product::where('category_id', '7');

        // Apply filters based on query parameters
        // Handle price_min only if not null
        // Check if price_min is provided
        // Apply filters only if values are not null or empty
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        // Fetch the filtered results
        $products = $query->get(['id', 'name', 'price', 'ingredients', 'image']);

        return response()->json($products);
    }

    public function getSnackboxesProducts(Request $request): \Illuminate\Http\JsonResponse
    {
        //global $request;
        $query = Product::where('category_id', '8');

        // Apply filters based on query parameters
        // Handle price_min only if not null
        // Check if price_min is provided
        // Apply filters only if values are not null or empty
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        // Fetch the filtered results
        $products = $query->get(['id', 'name', 'price', 'ingredients', 'image']);

        return response()->json($products);
    }

    public function getMysteryBox(Request $request): \Illuminate\Http\JsonResponse
    {
        //global $request;
        $query = MysteryBox::with([
            'product:id,name,slug,price,image,category_id'
        ])->whereHas('product', function ($q) {
            $q->where('category_id', 9);
        });

        // Apply filters based on query parameters
        // Handle price_min only if not null
        // Check if price_min is provided
        // Apply filters only if values are not null or empty
        if ($request->filled('price_min')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('price', '>=', $request->input('price_min'));
            });
        }

        if ($request->filled('price_max')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('price', '<=', $request->input('price_max'));
            });
        }

        // Fetch the filtered results
        $mysteryBoxes = $query->get()->map(function ($box) {
            return [
                'category' => $box->category,
                'description' => $box->description,
                'product' => [
                    'id' => $box->product->id ?? null,
                    'name' => $box->product->name ?? null,
                    'slug' => $box->product->slug ?? null,
                    'price' => $box->product->price ?? null,
                    'image' => $box->product->image ?? null,
                ],
            ];
        });

        return response()->json($mysteryBoxes);
    }


    public function show($id): \Illuminate\Http\JsonResponse
    {
        $products = Product::find($id, ['id', 'name', 'price', 'ingredients', 'image', 'category_id']);

        if (!$products) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($products);
    }

    public function showMysteryBox($productId)
    {
        $box = MysteryBox::with([
            'product:id,name,price,image'
        ])->where('product_id', $productId)->first();

        if (!$box) {
            return response()->json(['error' => 'Mystery Box not found'], 404);
        }

        return response()->json([
            'id' => $box->product->id,
            'name' => $box->product->name ?? 'Mystery Box',
            'price' => $box->product->price ?? null,
            'image' => $box->product->image ?? null,
            'description' => $box->description,
        ]);
    }

//     for search bar for suggestions
    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('ingredients', 'LIKE', "%{$query}%")
            ->get();

//        return view('products.search-results', compact('products', 'query'));
//        return Inertia::render('SearchResults', [
//            'products' => $products,
//            'query' => $query,
//        ]);
        return response()->json($products);
    }

}
