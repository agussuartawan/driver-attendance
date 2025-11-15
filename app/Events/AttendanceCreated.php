<?php

namespace App\Events;

use App\Models\Attendance;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AttendanceCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    public function __construct(Attendance $attendance)
    {
        $user = $attendance->employee;
        $schedule = $attendance->schedule;
        $typeLabel = $attendance->type === 'in' ? 'Masuk' : 'Keluar';

        // Get all users with admin or manager role
        $adminManagerUsers = User::role(['admin', 'manager'])->get();

        $notificationData = [
            'type' => 'attendance',
            'title' => "Absensi {$typeLabel}",
            'message' => "{$user->name} melakukan absensi {$typeLabel} untuk jadwal {$schedule->customer_name}",
            'icon' => 'calendar',
            'color' => $attendance->type === 'in' ? 'green' : 'blue',
            'url' => route('report.attendance'),
            'related_id' => $attendance->id,
            'related_type' => Attendance::class,
            'read' => false,
        ];

        // Create notification for each admin/manager user
        $notifications = [];
        foreach ($adminManagerUsers as $adminUser) {
            $notification = Notification::create(array_merge($notificationData, [
                'notifiable_type' => User::class,
                'notifiable_id' => $adminUser->id,
            ]));
            $notifications[] = $notification;
        }

        // Broadcast notification data (will be filtered by user on frontend)
        if (count($notifications) > 0) {
            $firstNotification = $notifications[0];
            $this->notification = [
                'id' => $firstNotification->id,
                'type' => $firstNotification->type,
                'title' => $firstNotification->title,
                'message' => $firstNotification->message,
                'icon' => $firstNotification->icon,
                'color' => $firstNotification->color,
                'url' => $firstNotification->url,
                'read' => $firstNotification->read,
                'time' => $firstNotification->created_at->diffForHumans(),
                'user_id' => null, // Will be set per user on frontend
            ];

            Log::info('AttendanceCreated event broadcasting', [
                'notification_id' => $firstNotification->id,
                'broadcast_connection' => config('broadcasting.default'),
            ]);
        }
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('notifications'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'notification.created';
    }
}
