<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
    public function getChipsProducts(Request $request): \Illuminate\Http\JsonResponse
    {

        //global $request;
        $query = Products::where('category_id', '1');

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
        $query = Products::where('category_id', '2');

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
        $query = Products::where('category_id', '3');

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
        $query = Products::where('category_id', '4');

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
        $query = Products::where('category_id', '5');

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
        $query = Products::where('category_id', '6');

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
        $query = Products::where('category_id', '7');

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
        $query = Products::where('category_id', '8');

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


    public function show($id): \Illuminate\Http\JsonResponse
    {
        $products = Products::find($id, ['id', 'name', 'price', 'ingredients', 'image', 'category_id']);

        if (!$products) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($products);
    }

//     for search bar for suggestions
    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Products::where('name', 'LIKE', "%{$query}%")
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
