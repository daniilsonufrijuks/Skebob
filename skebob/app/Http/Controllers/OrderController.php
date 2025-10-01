<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\StripeClient;

class OrderController extends Controller
{
//    public function store(Request $request): \Illuminate\Http\JsonResponse
//    {
//        $request->validate([
//            'items' => 'required|array',
//            'items.*.name' => 'required|string',
//            'items.*.price' => 'required|numeric',
//            'items.*.ingredients' => 'nullable|string',
//            'items.*.image' => 'nullable|string',
//            'items.*.category_id' => 'required|int',
//            'items.*.total_price' => 'required|numeric',
//            'items.*.shipping_address' => 'nullable|string',
//            'items.*.id' => 'required|integer',
//            'items.*.quantity' => 'required|integer|min:1',
//            'total' => 'required|numeric',
//            'unit_price' => 'nullable|numeric',
//        ]);
//
////        $orderNumber = uniqid();
//        $orderNumber = uniqid();
//
//        $order = Order::create([
//            'user_id' => auth()->id(),
////            'items' => json_encode($request->items),
////            'items' => $orderNumber,
//            'total' => $request->total ?? 0,
//        ]);
//
//        // Attach each item to the order (assuming you have an OrderItem model)
////        foreach ($request['items'] as $item) {
////            $order->items()->create([
////                'product_id' => $item['id'],
////                'quantity' => $item['quantity'],
////                'price' => $item['price'],
////            ]);
////        }
////
////        // Return Stripe session ID for redirect
////        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
////        $session = $stripe->checkout->sessions->create([
////            'payment_method_types' => ['card'],
////            'line_items' => array_map(function ($item) {
////                return [
////                    'price_data' => [
////                        'currency' => 'usd',
////                        'product_data' => ['name' => $item['name']],
////                        'unit_amount' => $item['price'] * 100, // Stripe expects amount in cents
////                    ],
////                    'quantity' => $item['quantity'],
////                ];
////            }, $request['items']),
////            'mode' => 'payment',
////            'success_url' => url('/order-success?session_id={CHECKOUT_SESSION_ID}'),
////            'cancel_url' => url('/cart'),
////        ]);
////
////        return response()->json(['id' => $session->id]);
//
//
//        $itemIds = [];
//
//        foreach ($request->items as $item) {
////            \Log::info('Processing item:', $item);
//            $orderItem = \App\Models\OrderItem::create([
//                'order_id' => $order->id,
////                'order_number' => $orderNumber,
//                'product_id' => $item['id'],
////                'status' => 'pending',
////                'name' => $item['name'],
////                'unit_price' => $item['price'],
////                'ingredients' => $item['ingredients'] ?? null,
////                'image' => $item['image'] ?? null,
////                'category' => $item['category'],
//                'category_id' => $item['category_id'] ?? null,  // Check if category exists
//                'quantity' => $item['quantity'],
////                'total_price' => $item['total_price'] ?? null,
////                'shipping_address' => $item['shipping_address'] ?? null,
//            ]);
//
//            $itemIds[] = $orderItem->id;
//
//            $order->products()->attach($item['id'], [
//                'quantity' => $item['quantity'],
//                'unit-price' => $item['price'],
//            ]);
//        }
//
//        // Store only the item IDs in the orders table
////        $order->items = implode(',', $itemIds);  // Store as a comma-separated string
//        $order->save();
//
//
//
//        return response()->json([
//            'message' => 'Order placed successfully!',
//            'order' => $order,
//        ]);
//        $request->validate([
////            'items' => 'required|array',
////            'total' => 'required|numeric',
//            'items' => 'required|array',
//            'items.*.id' => 'required|integer',
//            'items.*.name' => 'required|string',
//            'items.*.price' => 'required|numeric',
//            'items.*.quantity' => 'required|integer',
//            'total' => 'required|numeric',
//        ]);
//
//        $user = $request->user();
//        // Initialize Stripe client
//        $stripe = new StripeClient(env('STRIPE_SECRET'));
//
//        try {
//            // Create a payment
//            $payment = $stripe->paymentIntents->create([
//                'amount' => $request->total * 100, // Stripe uses cents
//                'currency' => 'usd',
//                'payment_method' => $request->payment_method_id,
//                'confirm' => true,
//            ]);
//
//            // Store the order after successful payment
//            $order = Orders::create([
//                'user_id' => $user->id,
//                'items' => json_encode($request->items),
//                'total' => $request->total,
//            ]);
//
//            return response()->json([
//                'message' => 'Order placed successfully!',
//                'order' => $order,
//            ]);
//
//        } catch (\Exception $e) {
//            return response()->json([
//                'message' => 'Payment failed: ' . $e->getMessage(),
//            ], 400);
//        }
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer|min:1',
            'total' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'shipping_cost' => 'required|numeric',
            'shipping_address' => 'required|array',
            'shipping_address.email' => 'required|email',
            'shipping_address.address' => 'required|string',
            'shipping_address.city' => 'required|string',
            'shipping_address.zipCode' => 'required|string',
            'shipping_address.country' => 'required|string',
        ]);

        try {
            // Store order data in session with a unique key
            $sessionKey = 'order_' . uniqid();
            session([$sessionKey => [
                'user_id' => auth()->id(),
                'items' => $request->items,
                'total' => $request->total,
                'subtotal' => $request->subtotal,
                'shipping_cost' => $request->shipping_cost,
                'shipping_address' => $request->shipping_address,
                'created_at' => now(),
            ]]);

            // Create Stripe session
            Stripe::setApiKey(config('services.stripe.secret'));

            $lineItems = [];
            foreach ($request->items as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item['name'],
                        ],
                        'unit_amount' => (int)($item['price'] * 100),
                    ],
                    'quantity' => $item['quantity'],
                ];
            }

            if ($request->shipping_cost > 0) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Shipping Fee',
                        ],
                        'unit_amount' => (int)($request->shipping_cost * 100),
                    ],
                    'quantity' => 1,
                ];
            }

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => url('/order-success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('/order-overview'),
                'customer_email' => $request->shipping_address['email'],
                'metadata' => [
                    'session_key' => $sessionKey, // Store session key instead of all data
                ],
            ]);

            return response()->json(['id' => $session->id]);

        } catch (\Exception $e) {
            \Log::error('Stripe session creation failed: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error creating payment session: ' . $e->getMessage()
            ], 500);
        }
    }

    public function handleSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect('/order-overview')->with('error', 'Invalid session');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                // Get the session key from metadata
                $sessionKey = $session->metadata->session_key;
                $orderData = session($sessionKey);

                if ($orderData) {
                    // Create the order
                    $order = Order::create([
                        'user_id' => $orderData['user_id'],
                        'status' => 'paid',
                        'total_price' => $orderData['total'],
                        'shipping_address' => $this->formatShippingAddress($orderData['shipping_address']),
                        'ordered_at' => now(),
                    ]);

                    // Create order items
                    foreach ($orderData['items'] as $item) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $item['id'],
                            'quantity' => $item['quantity'],
                            'unit-price' => $item['price'],
                            'subtotal' => $item['price'] * $item['quantity'],
                        ]);
                    }

                    // Clear the session data
                    session()->forget($sessionKey);

                    return redirect('/order-confirmation')
                        ->with('success', 'Order placed successfully!')
                        ->with('order_id', $order->id);
                } else {
                    \Log::error('Order data not found in session for key: ' . $sessionKey);
                    return redirect('/order-overview')->with('error', 'Order data not found');
                }
            }

        } catch (\Exception $e) {
            \Log::error('Order creation failed: ' . $e->getMessage());
        }

        return redirect('/order-overview')->with('error', 'Payment failed');
    }



//     dont use this function now
    private function createOrder($session)
    {
        $metadata = $session->metadata;
        $items = json_decode($metadata->items_data, true);
        $shippingAddress = json_decode($metadata->shipping_address, true);

        // Create order
        $order = Order::create([
            'user_id' => $metadata->user_id,
            'status' => 'paid',
            'total_price' => $metadata->total_amount,
            'shipping_address' => $this->formatShippingAddress($shippingAddress),
            'ordered_at' => now(),
        ]);

        // create order items
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit-price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        return $order;
    }

    private function formatShippingAddress($address)
    {
        return "{$address['address']}, {$address['city']}, {$address['zipCode']}, {$address['country']}";
    }
}
