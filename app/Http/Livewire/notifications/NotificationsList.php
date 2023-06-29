<?php

namespace App\Http\Livewire\notifications;

use Livewire\Component;

class NotificationsList extends Component
{
    public $notificationsAmount;
    public $initNotificationsAmount = 3;

    public $notifications;

    protected $listeners = [
        'refresh-notifications' => '$refresh',
    ];

    public function mount()
    {
        $this->ShowLessNotifications();
    }

    public function GetAllNotificationsSorted()
    {
        // Sort by created_at, unread first, then readed
        $this->notifications = auth()->user()->notifications()
            ->orderByRaw("case when read_at IS NULL then 0 else 1 end")
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function ShowAllNotifications()
    {
        $this->notificationsAmount = auth()->user()->notifications()->count();
    }

    public function ShowLessNotifications()
    {
        $this->notificationsAmount = $this->initNotificationsAmount;
    }

    public function DeleteNotification($notification)
    {
        auth()->user()->notifications->find($notification)->delete();
    }

    public function DeleteNotifications()
    {
        auth()->user()->notifications()->delete();
    }

    public function ReadNotification($notification)
    {
        auth()->user()->notifications->find($notification)->markAsRead();
    }

    public function ReadNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function render()
    {
        $this->GetAllNotificationsSorted();
        return view('livewire.notifications.notifications-list');
    }
}
