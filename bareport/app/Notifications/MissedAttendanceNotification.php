<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MissedAttendanceNotification extends Notification
{
    use Queueable;

    protected $attendanceRequest;
    protected $reasonTitle;

    /**
     * Create a new notification instance.
     */
    public function __construct(\App\Models\AttendanceRequest $attendanceRequest, $reasonTitle)
    {
        $this->attendanceRequest = $attendanceRequest;
        $this->reasonTitle = $reasonTitle;
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
        $message = $this->reasonTitle === 'Alpha'
            ? "Sistem mendeteksi Anda belum melakukan absensi masuk (Alpha) hari ini."
            : "Sistem mendeteksi Anda lupa melakukan Check-out hari ini.";

        return [
            'request_id' => $this->attendanceRequest->id,
            'user_name' => $notifiable->name,
            'type' => $this->attendanceRequest->type,
            'date' => $this->attendanceRequest->date,
            'reason' => $this->attendanceRequest->reason,
            'message' => $message,
            'url' => route('attendance.request.index'),
        ];
    }
}
