<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use App\Models\User;

class StripeController extends Controller
{
    public function create(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = collect($request->items)->map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => intval($item['price'] * 100), // Stripe uses cents
                ],
                'quantity' => $item['quantity'],
            ];
        })->toArray();
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => url('/'),
            'cancel_url' => url('/cart'),
        ]);

        return response()->json(['id' => $session->id]);
    }

    /*
     * Separate create method for subscription.
     */
    public function createSubscriptionSession(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:products,id',
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);
        Stripe::setApiKey(config('services.stripe.secret'));
        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $request->name,
                            'description' => 'SNACKtastic Subscription - Free Mystery Box every 2 months',
                        ],
                        'unit_amount' => intval($request->price * 100),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => url('/subscription/success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('/subscriptions'),
                'metadata' => [
                    'subscription_id' => $request->subscription_id,
                    'user_id' => auth()->id(),
                    'type' => 'subscription'
                ],
            ]);
            return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            \Log::error('Stripe subscription session error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create subscription session'], 500);
        }
    }

    public function subscriptionSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');
        if (!$sessionId) {
            return redirect('/')->with('error', 'Invalid session');
        }
        Stripe::setApiKey(config('services.stripe.secret'));
        try {
            $session = Session::retrieve($sessionId);
            // Check if payment was successful
            if ($session->payment_status === 'paid') {
                $userId = $session->metadata->user_id;
                // Activate subscription
                $user = User::find($userId);
                if ($user) {
                    $user->has_subscription = true;
                    $user->save();
                    // Redirect with URL parameter instead of cookie
                    return redirect('/?just_subscribed=true');
                }
            }
            return redirect('/')->with('error', 'Payment not completed');
        } catch (\Exception $e) {
            Log::error('Error processing subscription success: ' . $e->getMessage());
            return redirect('/')->with('error', 'Error processing your subscription');
        }
    }
}
