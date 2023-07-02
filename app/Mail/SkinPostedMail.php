<?php

namespace App\Mail;

use App\Models\Skin;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SkinPostedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $skin;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Skin $skin, User $user)
    {
        $this->skin = $skin;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: config('app.name') . ' - Skin Posté ID#' . $this->skin->id,
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
            markdown: 'mails.skin-posted',
            with: [
                'url' => \url()->route('skins.show', ['skin' => $this->skin->id]),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
