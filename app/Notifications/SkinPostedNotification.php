<?php

namespace App\Notifications;

use App\Mail\SkinPostedMail;
use App\Models\Skin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SkinPostedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $skin;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Skin $skin)
    {
        $this->skin = $skin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $wantMail = $notifiable->NotificationPreferences->where('notification_type', '=', 'mail_skin_validation')->where('value', '=', '0')->count() == 0;

        if($wantMail) {
            return ['database', 'mail'];
        }

        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new SkinPostedMail($this->skin, $notifiable))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'model' => 'App\Models\Skin',
            'id' => $this->skin->id,
            'component' => 'skin-posted'
        ];
    }
}
