<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AttendanceRequestProcessed extends Notification
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
        $statusLabel = $this->request->status === 'approved' ? 'DISETUJUI' : 'DITOLAK';
        $requestType = $this->request->type === 'day-off' ? 'Day Off' : 'Lupa Absen';

        return [
            'request_id' => $this->request->id,
            'status' => $this->request->status,
            'message' => "Pengajuan {$requestType} Anda pada tanggal {$this->request->date} telah {$statusLabel}",
            'admin_note' => $this->request->admin_note,
            'url' => route('attendance.request.index'),
        ];
    }
}
