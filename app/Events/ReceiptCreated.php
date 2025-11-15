<?php

namespace App\Events;

use App\Models\Receipt;
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

class ReceiptCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    public function __construct(Receipt $receipt)
    {
        $user = $receipt->user;
        $schedule = $receipt->schedule;
        $amount = number_format($receipt->amount, 0, ',', '.');

        // Get all users with admin or manager role
        $adminManagerUsers = User::role(['admin', 'manager'])->get();

        $notificationData = [
            'type' => 'receipt',
            'title' => 'Nota Biaya Baru',
            'message' => "{$user->name} mengupload nota biaya {$receipt->category} sebesar Rp {$amount} untuk jadwal {$schedule->customer_name}",
            'icon' => 'currency-dollar',
            'color' => $receipt->amount > 500000 ? 'red' : 'yellow',
            'url' => route('receipt.show', $receipt->id),
            'related_id' => $receipt->id,
            'related_type' => Receipt::class,
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

            Log::info('ReceiptCreated event broadcasting', [
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
