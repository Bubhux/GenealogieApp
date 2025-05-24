<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FamilyInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $person;
    public $token;
    public $message;

    public function __construct($person, $token, $customMessage)
    {
        $this->person = $person;
        $this->token = $token;
        $this->message = $customMessage;
    }

    public function build()
    {
        return $this->markdown('emails.family-invitation')
                    ->subject('Invitation famille '.$this->person->last_name)
                    ->with([
                        'url' => route('register', ['token' => $this->token]),
                        'person' => $this->person,
                        'message' => $this->message,
                    ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation à rejoindre notre arbre généalogique',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.family-invitation',
            with: [
                'url' => route('register', ['token' => $this->token]),
                'person' => $this->person,
                'message' => $this->message,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
