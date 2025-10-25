<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Log;
//use Illuminate\Database\Query\Builder;
//use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Session;
use Psy\Readline\Hoa\Console;
/**
 * Post
 *
 * @mixin Builder
 * @mixin \Illuminate\Database\Eloquent\Builder
 */

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Registration');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
//    public function store(Request $request): RedirectResponse
//    {
//        $request->validate([
////            'name' => 'required|string|max:255',
//            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
//            'password' => ['required', 'confirmed', Rules\Password::defaults()],
//        ]);
//        //dd('User created successfully!');
//        //dump("Start");
//
//        // Extract the name from the email (everything before the '@')
//        $name = strstr($request->email, '@', true);
//        $user = User::create([
//            'name' => $name,
//            'email' => $request->email,
//            'password' => Hash::make($request->password),
//        ]);
//
//        Auth::login($user);
//        // Send a welcome email
////        Mail::to($user->email)->send(new WelcomeEmail($user));
//        // Try sending the email and catch errors
//        try {
//            Mail::to($user->email)->send(new WelcomeEmail($user));
////            Log::info('Email sent successfully to: ' . $user->email);
//        } catch (\Exception $e) {
////            Log::error('Email sending failed: ' . $e->getMessage());
//            return back()->with('error', 'Failed to send email. Please try again.');
//        }
//        //dump("end");
//        //dd('User created successfully!');
//        //event(new Registered($user));
////        Auth::login($user);
////        auth()->login($user);
//
//        return redirect(route('home', absolute: false));
//
//    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/'
            ],
        ], [
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'The password is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.regex' => 'The password must contain letters, numbers, and symbols.',
        ]);
        // Extract the name from the email
        $name = strstr($request->email, '@', true);

        // Generate token for confirmation
        $token = Str::random(32);

        // Prepare temporary user data
        $pendingUser = [
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'token' => $token,
        ];

        // Save to session for verify/resend
        session(['pending_user' => $pendingUser]);
        // Send verification email
        try {
            Mail::to($pendingUser['email'])->send(new ContactMail($pendingUser));
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }

        // Redirect to notice page
        return redirect()->route('verification.notice')
            ->with('status', 'verification-link-sent');
    }

    public function verify(string $token): RedirectResponse
    {
        $pending = Session::get('pending_user');

        if (!$pending || $pending['token'] !== $token) {
            return redirect()->route('register')->with('error', 'Invalid or expired verification link.');
        }

        $user = User::create([
            'name' => $pending['name'],
            'email' => $pending['email'],
            'password' => $pending['password'],
        ]);

        Session::forget('pending_user');

        // Sending a welcome email
        try {
            Mail::to($user->email)->send(new WelcomeEmail($user));
        } catch (\Exception $e) {
            return redirect()->route('login')->with('warning', 'The user was created, but the welcome email could not be sent.');
        }

        Auth::login($user);
        return redirect()->route('home')->with('success', 'Registration successfully confirmed!');
    }
    public function resend(): RedirectResponse
    {
        $pending = Session::get('pending_user');

        if (!$pending) {
            return redirect()->route('register')->with('error', 'No registration data found.');
        }

        $pending['token'] = Str::random(32);
        session(['pending_user' => $pending]);

        Mail::to($pending['email'])->send(new ContactMail($pending));

        return back()->with('status', 'verification-link-sent');
    }
}
