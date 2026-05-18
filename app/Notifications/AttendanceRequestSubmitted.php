<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AttendanceRequestSubmitted extends Notification
{
    use Queueable;

    protected $request;

    /**
     * Create a new notification instance.
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $requestType = $this->request->type === 'day-off' ? 'Day Off' : 'lupa absen';

        return [
            'request_id' => $this->request->id,
            'user_name' => $this->request->user->name,
            'type' => $this->request->type,
            'date' => $this->request->date,
            'reason' => $this->request->reason,
            'message' => "Pengajuan {$requestType} baru dari " . $this->request->user->name,
            'url' => route('admin.attendance-requests.index'),
        ];
    }
}
