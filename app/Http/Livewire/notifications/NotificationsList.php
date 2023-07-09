<?php

namespace App\Http\Livewire\notifications;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\View;
use Livewire\Component;

class NotificationsList extends Component
{
    public int $notificationsAmount;

    public int $initNotificationsAmount = 3;

    public mixed $notifications;

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh-notifications' => '$refresh',
    ];

    /**
     * @return void
     */
    public function mount()
    {
        $this->ShowLessNotifications();
    }

    /**
     * @return void
     */
    public function GetAllNotificationsSorted()
    {
        // Sort by created_at, unread first, then readed
        $this->notifications = auth()->user()->notifications()
            ->orderByRaw('case when read_at IS NULL then 0 else 1 end')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @return void
     */
    public function ShowAllNotifications()
    {
        $this->notificationsAmount = auth()->user()->notifications()->count();
    }

    /**
     * @return void
     */
    public function ShowLessNotifications()
    {
        $this->notificationsAmount = $this->initNotificationsAmount;
    }

    /**
     * @return void
     */
    public function DeleteNotification(DatabaseNotification $notification)
    {
        auth()->user()->notifications->find($notification)->delete();
    }

    /**
     * @return void
     */
    public function DeleteNotifications()
    {
        auth()->user()->notifications()->delete();
    }

    /**
     * @return void
     */
    public function ReadNotification(DatabaseNotification $notification)
    {
        auth()->user()->notifications->find($notification)->markAsRead();
    }

    /**
     * @return void
     */
    public function ReadNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    /**
     * @return View
     */
    public function render()
    {
        $this->GetAllNotificationsSorted();

        return view('livewire.notifications.notifications-list');
    }
}
