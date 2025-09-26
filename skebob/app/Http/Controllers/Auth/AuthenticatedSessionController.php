<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
//        $request->authenticate();
//
//        $request->session()->regenerate();
//
//        return redirect()->intended(route('home', absolute: false));
        // First, check if it's an admin login
//        $admin = Admin::where('name', $request->email)->first();

        // If admin exists, attempt login with admin credentials
        $admin = Admin::where('name', $request->email)->first();

        if ($admin && Auth::guard('admin')->attempt(['name' => $request->email, 'password' => $request->password])) {
            // Regenerate the session after successful admin login
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard'); // Redirect to the admin dashboard
        }

        // Else, proceed with the normal user login (based on email)
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Regenerate the session after successful user login
            $request->session()->regenerate();
            return redirect()->intended(route('home', absolute: false)); // Redirect to home page
        }
        // If login fails, return with an error
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
