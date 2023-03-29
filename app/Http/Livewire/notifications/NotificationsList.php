<?php

namespace App\Http\Livewire\notifications;

use Livewire\Component;

class NotificationsList extends Component
{
    public $notificationsAmount;
    public $initNotificationsAmount = 5;

    public function mount()
    {
        $this->ShowLessNotifications();
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
        return view('livewire.notifications.notifications-list');
    }
}
