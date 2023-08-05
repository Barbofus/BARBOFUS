<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The user who will receive the verification email
     *
     * @var mixed
     */
    public $notifiable;

    public User $user;

    /**
     * Verification email URL
     *
     * @var mixed
     */
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(mixed $notifiable, mixed $url)
    {
        $this->notifiable = $notifiable;
        $this->user = User::find($notifiable->id);
        $this->url = $url;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: config('app.name').' - Verification d\'E-mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.verify-email',
        );
    }
}
