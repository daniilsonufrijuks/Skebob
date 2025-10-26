<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MysteryBox;
use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\StripeClient;

class OrderController extends Controller
{
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
            // store order data in session with a unique key
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
            // create Stripe session
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
                    'session_key' => $sessionKey, // store session key instead of all data
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

    public function handleSuccess(Request $request) {
        $sessionId = $request->get('session_id');
        if (!$sessionId) {
            return redirect('/order-overview')->with('error', 'Invalid session');
        }
        Stripe::setApiKey(config('services.stripe.secret'));
        try {
            $session = Session::retrieve($sessionId);
            if ($session->payment_status === 'paid') {
                // get the session key from metadata
                $sessionKey = $session->metadata->session_key;
                $orderData = session($sessionKey);
                if ($orderData) {
                    // create the order
                    $order = Order::create([
                        'user_id' => $orderData['user_id'],
                        'status' => 'paid',
                        'total_price' => $orderData['total'],
                        'shipping_address' => $this->formatShippingAddress($orderData['shipping_address']),
                        'ordered_at' => now(),
                    ]);
                    // create order items
                    foreach ($orderData['items'] as $item) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $item['id'],
                            'quantity' => $item['quantity'],
                            'unit-price' => $item['price'],
                            'subtotal' => $item['price'] * $item['quantity'],
                        ]);
                    }
                    // clear the session data
                    session()->forget($sessionKey);
                    return redirect('/order-confirmation?order_id=' . $order->id);
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



    /**
     * Create new order. @obsolete
     */

//    private function createOrder($session)
//    {
//        $metadata = $session->metadata;
//        $items = json_decode($metadata->items_data, true);
//        $shippingAddress = json_decode($metadata->shipping_address, true);
//
//        // Create order
//        $order = Order::create([
//            'user_id' => $metadata->user_id,
//            'status' => 'paid',
//            'total_price' => $metadata->total_amount,
//            'shipping_address' => $this->formatShippingAddress($shippingAddress),
//            'ordered_at' => now(),
//        ]);
//
//        // create order items
//        foreach ($items as $item) {
//            OrderItem::create([
//                'order_id' => $order->id,
//                'product_id' => $item['id'],
//                'quantity' => $item['quantity'],
//                'unit-price' => $item['price'],
//                'subtotal' => $item['price'] * $item['quantity'],
//            ]);
//        }
//
//        return $order;
//    }

    private function formatShippingAddress($address)
    {
        return "{$address['address']}, {$address['city']}, {$address['zipCode']}, {$address['country']}";
    }

    public function show($id)
    {
        try {
            $order = Order::with('orderItems.product')->findOrFail($id);
            if (auth()->check() && $order->user_id !== auth()->id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            // transform the data for the frontend
            $formattedOrder = [
                'id' => $order->id,
                'total_price' => $order->total_price,
                'shipping_address' => $order->shipping_address,
                'ordered_at' => $order->ordered_at,
                'status' => $order->status,
            ];
            $formattedItems = $order->orderItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->product->name ?? 'Product',
                    'description' => $item->product->description ?? '',
                    'price' => $item->{'unit-price'},
                    'quantity' => $item->quantity,
                    'image' => $item->product->image ?? '/default-image.jpg',
                ];
            });
            return response()->json([
                'order' => $formattedOrder,
                'items' => $formattedItems
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Order not found'], 404);
        }
    }

    public function userOrders()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        // fetch orders for the logged-in user
        $orders = Order::where('user_id', $user->id)
            ->orderBy('ordered_at', 'desc')
            ->get(['id', 'total_price', 'status', 'ordered_at', 'shipping_address']);

        return response()->json($orders);
    }

    /*
     * Handle free mystery box claim from subscription.
     */
    public function handleMysteryBoxClaim(Request $request)
    {
        $request->validate([
            'mystery_box_id' => 'required|exists:mystery_boxes,id',
            'product_id' => 'required|exists:products,id',
            'shipping_address' => 'required|array',
            'shipping_address.email' => 'required|email',
            'shipping_address.address' => 'required|string',
            'shipping_address.city' => 'required|string',
            'shipping_address.zipCode' => 'required|string',
            'shipping_address.country' => 'required|string',
        ]);
        try {
            // get the authenticated user
            $user = auth()->user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }
            // verify user has active subscription
            if (!$user->has_subscription) {
                return response()->json(['error' => 'User does not have active subscription'], 400);
            }
            // get the mystery box and product
            $mysteryBox = MysteryBox::with('product')->find($request->mystery_box_id);
            $product = Product::find($request->product_id);
            if (!$mysteryBox || !$product) {
                return response()->json(['error' => 'Mystery box or product not found'], 404);
            }
            // create the order
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'processing',
                'total_price' => 0.00, // free for subscribers
                'shipping_address' => $this->formatShippingAddress($request->shipping_address),
                'ordered_at' => now(),
                'notes' => 'Free mystery box from subscription',
            ]);
            // create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'unit-price' => $product->price,
                'subtotal' => 0.00, // free for subscribers
            ]);

            // log the mystery box claim for tracking
            \Log::info("Mystery box claimed", [
                'user_id' => $user->id,
                'order_id' => $order->id,
                'mystery_box_id' => $mysteryBox->id,
                'product_id' => $product->id,
                'mystery_box_name' => $product->name,
            ]);
            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'message' => 'Mystery box claimed successfully!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Mystery box claim failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to claim mystery box: ' . $e->getMessage()], 500);
        }
    }

}
