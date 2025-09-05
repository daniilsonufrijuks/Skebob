<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function userProfile()
    {
        // Fetch the authenticated user
        $user = auth()->user(); // Ensure authentication middleware is applied

        // Return data to the Vue component via Inertia
        return Inertia::render('User', [
            'user' => $user
        ]);
    }
}
