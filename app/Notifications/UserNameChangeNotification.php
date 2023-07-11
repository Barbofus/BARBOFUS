<?php

namespace App\Notifications;

use App\Mail\UserNameChangeMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class UserNameChangeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public User $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return UserNameChangeMail
     */
    public function toMail($notifiable)
    {
        return (new UserNameChangeMail($this->user))->to($notifiable->email);
    }
}
