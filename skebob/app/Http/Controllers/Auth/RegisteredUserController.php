<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\User;
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
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
//            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        //dd('User created successfully!');
        //dump("Start");

        // Extract the name from the email (everything before the '@')
        $name = strstr($request->email, '@', true);
        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        // Send a welcome email
//        Mail::to($user->email)->send(new WelcomeEmail($user));
        // Try sending the email and catch errors
        try {
            Mail::to($user->email)->send(new WelcomeEmail($user));
//            Log::info('Email sent successfully to: ' . $user->email);
        } catch (\Exception $e) {
//            Log::error('Email sending failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to send email. Please try again.');
        }
        //dump("end");
        //dd('User created successfully!');
        //event(new Registered($user));
//        Auth::login($user);
//        auth()->login($user);

        return redirect(route('home', absolute: false));

    }
}
