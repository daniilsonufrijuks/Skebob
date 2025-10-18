<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserContact extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;
    public string $email;
    public string $body;

    /**
     * Create a new message instance.
     */
    public function __construct(string $name, string $email, string $body)
    {
        $this->name = $name;
        $this->email = $email;
        $this->body = $body;
    }

    /**
     * Define the email envelope (subject, etc.)
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Question –'. now()->format('H:i:s'),
        );
    }

    /**
     * Define the email content (view + variables)
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user_form',
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'body' => $this->body,
            ],
        );
    }
}
