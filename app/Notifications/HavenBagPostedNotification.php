<?php

namespace App\Notifications;

use App\Models\HavenBag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class HavenBagPostedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public HavenBag $havenBag;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(HavenBag $havenBag)
    {
        $this->havenBag = $havenBag;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, int|string>
     */
    public function toArray($notifiable)
    {
        return [
            'model' => 'App\Models\HavenBag',
            'id' => $this->havenBag->id,
            'name' => $this->havenBag->name,
            'info' => $this->havenBag->havenBagTheme->name,
            'component' => 'haven-bag-posted',
        ];
    }
}
