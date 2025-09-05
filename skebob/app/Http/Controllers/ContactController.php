<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
//    public function send(Request $request): \Illuminate\Http\JsonResponse
//    {
//        $request->validate([
//            'name' => 'required|string|max:255',
//            'email' => 'required|email|max:255',
//            'subject' => 'required|string|max:255',
//            'message' => 'required|string',
//        ]);
//
//        // Send email using a mailable or inline HTML view
//        Mail::send([], [], function ($message) use ($request) {
//            $message->to('your-email@example.com') // Replace with your email
//            ->subject($request->subject)
//                ->setBody(
//                    "<p><strong>Name:</strong> {$request->name}</p>
//                    <p><strong>Email:</strong> {$request->email}</p>
//                    <p><strong>Message:</strong><br>{$request->message}</p>",
//                    'text/html'
//                );
//        });
//
//        return response()->json(['message' => 'Your message has been sent successfully!'], 200);
//    }

    public function __invoke(ContactRequest $request)
    {
        Mail::to('monolithabout@gmail.com')->send(new ContactMail($request->name, $request->email, $request->body));
        return redirect()->back();
    }
}
