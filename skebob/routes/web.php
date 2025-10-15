<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
//use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouletteController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

//'routes' => [
//    'home' => route('home'),
//    'about' => route('about'),
//    'contacts' => route('contacts'),
//    'market' => route('market'),
//    'login' => route('login'),
//    'registration' => route('registration'),
//    // Add more routes here if needed
//],







Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/contacts', function () {
    return Inertia::render('Contact');
})->name('contacts');

Route::get('/market', function () {
    return Inertia::render('Market');
})->name('market');

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::get('/registration', function () {
    return Inertia::render('Auth/Registration');
})->name('registration');

Route::get('/chips', function () {
    return Inertia::render('Chips');
})->name('chips');

Route::get('/chocolates', function () {
    return Inertia::render('Chocolates');
})->name('chocolates');

Route::get('/drinks', function () {
    return Inertia::render('Drinks');
})->name('drinks');

Route::get('/cart', function () {
    return Inertia::render('Cart');
})->name('cart');

Route::get('/order-overview', function () {
    return Inertia::render('OrderOverview');
})->name('order-overview');

Route::get('/order-confirmation', function () {
    return Inertia::render('OrderConfirmation');
})->name('order-confirmation');

Route::get('/tutor', function () {
    return Inertia::render('Tutorials');
})->name('tutor');

//Route::get('/quiz', function () {
//    return Inertia::render('Quiz');
//})->name('quiz');

Route::get('/nuts', function () {
    return Inertia::render('Nuts');
})->name('nuts');

Route::get('/biscuits', function () {
    return Inertia::render('Biscuits');
})->name('biscuits');

Route::get('/fruitsnacks', function () {
    return Inertia::render('Fruitsnacks');
})->name('fruitsnacks');

Route::get('/candy', function () {
    return Inertia::render('Candy');
})->name('candy');

Route::get('/mystery-box', function () {
    return Inertia::render('MysteryBox');
})->name('mystery-box');

Route::get('/snackboxes', function () {
    return Inertia::render('Snackboxes');
})->name('snackboxes');

Route::get('/faq', function () {
    return Inertia::render('FAQ');
})->name('faq');

Route::get('/gifts', function () {
    return Inertia::render('Gifts');
})->name('gifts');















// for dinamic product displaying
//Route::get('/product', function () {
//    return Inertia::render('Product');
//})->name('product');

//Route::get('/product/{id}', function ($id) {
//    return Inertia::render('Product', [
//        'productId' => $id,  // Pass the product ID to the frontend
//    ]);
//})->name('product');


// sends products id from ProductCardDB to Product pagge
Route::get('/product', function (Request $request) {
//    return Inertia::render('Product', [
//        'productId' => $request->query('id'), // Pass the query parameter to the frontend
//    ]);
    $productId = $request->query('id'); // Extract 'id' from query parameters
    if (!$productId) {
        abort(400, 'Product ID is required');
    }
    return Inertia::render('Product', [
        'productId' => $productId, // Pass it to the Vue page
    ]);
})->name('product');

Route::get('/mystery-box-item', function (Request $request) {
    $boxId = $request->query('id');
    if (!$boxId) {
        abort(400, 'Box ID is required');
    }

    return Inertia::render('MysteryProduct', [
        'boxId' => $boxId,
    ]);
})->name('mystery-box-item');





Route::post('/contact', ContactController::class)->name('contact');


Route::get('/api/is-logged-in', function () {
    return response()->json([
        'isLoggedIn' => auth()->check(),
        'user' => auth()->user(), // Include the authenticated user
    ]);
});

// For web-based authentication (sessions)
Route::post('/logout', function () {
    auth()->logout();  // Log the user out
    session()->invalidate();  // Invalidate the session
    session()->regenerateToken();  // Regenerate CSRF token
    return response()->json(['message' => 'Logged out successfully']);
});





// for getting products for pages for categories
Route::get('/products/chips', [ProductsController::class, 'getChipsProducts']);
Route::get('/products/chocolates', [ProductsController::class, 'getChocolatesProducts']);
Route::get('/products/drinks', [ProductsController::class, 'getDrinksProducts']);
Route::get('/products/nuts', [ProductsController::class, 'getNutsProducts']);

Route::get('/products/biscuits', [ProductsController::class, 'getBiscuitsProducts']);
Route::get('/products/fruitsnacks', [ProductsController::class, 'getFruitsnacksProducts']);
Route::get('/products/candy', [ProductsController::class, 'getCandyProducts']);
Route::get('/products/snackboxes', [ProductsController::class, 'getSnackboxesProducts']);

Route::get('/products/mystery-boxes', [ProductsController::class, 'getMysteryBox']);

Route::get('/products/{id}', [ProductsController::class, 'show']);
Route::get('/mystery-boxes/{id}', [ProductsController::class, 'showMysteryBox']);

// Proceed to checkout (with session-based authentication)
Route::post('/order', [OrderController::class, 'store'])->middleware('auth');
Route::get('/order-success', [OrderController::class, 'handleSuccess'])->name('order.success');

Route::get('/orders/user', [OrderController::class, 'userOrders'])
    ->middleware('auth');

Route::get('/orders/{id}', [OrderController::class, 'show'])
    ->middleware('auth');

Route::middleware('auth')->get('/orders/{id}/details', function ($id) {
    return Inertia::render('OrderDetails', [
        'orderId' => $id,
    ]);
})->name('orders.details');


// to get user page about user
Route::get('/user', [UserController::class, 'userProfile'])->name('user');

// Profile update routes (using the existing ProfileController)
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile-delete', [ProfileController::class, 'destroy'])->name('profile.destroy');


// admin page and get/post
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::get('/admin/orders', [AdminController::class, 'showOrders'])->name('admin.orders');
Route::get('/admin/ordersj', [AdminController::class, 'showjoinedOrders'])->name('admin.j.orders');
Route::get('/admin/products', [AdminController::class, 'showProducts'])->name('admin.products');
Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.add');
Route::delete('/admin/products/{id}', [AdminController::class, 'destroyProduct']);
Route::delete('/admin/orders/{id}', [AdminController::class, 'destroyOrder']);
Route::delete('/admin/orderitems/{id}', [AdminController::class, 'destroyOrderItem']);
Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser']);
Route::put('/admin/products/{id}', [AdminController::class, 'updateProduct']);


// AI
Route::post('chatai', [ChatController::class, 'chat'])->name('chatai');


// for stripe after pressing proceed btn in cart
//Route::post('/checkout', [CheckoutController::class, 'checkout']);
Route::post('/stripe/checkout', [StripeController::class, 'create'])->name('stripe.checkout');


// to find products using search bar
//Route::get('/search', [ProductsController::class, 'search'])->name('products.search');
Route::get('/search', [ProductsController::class, 'search']);


// for comments
Route::get('/comments', [CommentController::class, 'index']);
Route::post('/comments', [CommentController::class, 'store']);

// for checking authenticated user (for displaying order history in the user page)
Route::get('/check-auth', function () {
    return response()->json([
        'user_id' => auth()->id(),
        'user' => auth()->user(),
    ]);
});

require __DIR__.'/auth.php';
