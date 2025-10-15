<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pending;

    public function __construct($pending)
    {
        $this->pending = $pending;
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email verification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            with: [
                'name' => $this->pending['name'],
                'token' => $this->pending['token'],
            ],
        );
    }
}
