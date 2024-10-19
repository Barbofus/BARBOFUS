<?php

namespace App\Mail;

use App\Models\Skin;
use App\Models\UnitySkin;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SkinRefusedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Skin|UnitySkin $skin;

    public User $user;

    public bool $isUnitySkin = false;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Skin|UnitySkin $skin, User $user, bool $isUnitySkin = false)
    {
        $this->skin = $skin;
        $this->user = $user;
        $this->isUnitySkin = $isUnitySkin;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: config('app.name').' - Skin Refusé '.(($this->skin->name) ?: 'ID#'.$this->skin->id),
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
            markdown: 'mails.skin-refused',
            with: [
                'url' => \url()->route($this->isUnitySkin ? 'unity-skins.edit' : 'skins.edit', [
                    'skin' => $this->skin->id,
                ]),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<string, mixed>
     */
    public function attachments()
    {
        return [];
    }
}
