<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\EventNotification;
use App\Services\Telegram\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Throwable;

class SendEventReminderJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public EventNotification $eventNotification) {}

    public function handle(TelegramService $telegramService): void
    {
        $event = $this->eventNotification->event;
        $user = $event->user;

        if (!$user->telegram_chat_id) {
            return;
        }

        $message =
            "⏰ <b>Reminder</b>

            Event: <b>{$event->title}</b>
            Time: {$event->scheduled_at->format('H:i')}
            Duration: {$event->duration_minutes} minutes";

        $telegramService->sendMessage($user->telegram_chat_id, $message);

        $this->eventNotification->update([
            'sent_at' => now()
        ]);
    }

    public function failed(Throwable $exception): void
    {
        logger()->error("Reminder failed for event {$this->eventNotification->event->id}");
    }
}