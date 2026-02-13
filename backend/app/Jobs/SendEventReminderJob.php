<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\EventNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Throwable;

class SendEventReminderJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public Event $event) {}

    public function handle(): void
    {
        DB::transaction(function () {

            $exists = EventNotification::where('event_id', $this->event->id)
                ->where('scheduled_for', $this->event->scheduled_at
                    ->copy()
                    ->subMinutes($this->event->remind_before_minutes))
                ->exists();

            if ($exists) {
                return;
            }

            $user = $this->event->user;

            logger()->info("Reminder sent to {$user->username} about {$this->event->title}");

            EventNotification::create([
                'event_id' => $this->event->id,
                'scheduled_for' => $this->event->scheduled_at
                    ->copy()
                    ->subMinutes($this->event->remind_before_minutes),
                'sent_at' => now(),
            ]);
        });
    }

    public function failed(Throwable $exception): void
    {
        logger()->error("Reminder failed for event {$this->event->id}");
    }
}