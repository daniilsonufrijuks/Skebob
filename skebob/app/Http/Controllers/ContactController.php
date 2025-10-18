<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Mail\UserContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    public function __invoke(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'body' => 'required|string',
        ]);

        Log::info('CONTACT FORM SUBMITTED', $validated);

        try {
            // Send email
            Mail::to('skebob-shop@outlook.com')->send(new UserContact(
                $validated['name'],
                $validated['email'],
                $validated['body']
            ));

            Log::info('MAIL SENT SUCCESSFULLY');

            return redirect()->back()->with('success', 'Your message has been sent successfully!');

        } catch (\Exception $e) {
            Log::error('MAIL SEND FAILED: ' . $e->getMessage());

            return redirect()->back()->with('error', 'There was an error sending your message. Please try again.');
        }
    }
}
