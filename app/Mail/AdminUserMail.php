<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $mailSubject;
    public string $mailBody;

    public function __construct(string $subject, string $body)
    {
        $this->mailSubject = $subject;
        $this->mailBody = $body;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-user',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
