<?php

namespace App\Services;

use App\Jobs\SendEventReminderJob;
use App\Models\Event;
use App\Models\EventNotification;
use App\Models\User;
use App\Repositories\Contracts\EventRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EventService
{
    public function __construct(
        private  EventRepositoryInterface $eventsRepo
    ) {}

    public function create(array $data, User $user): Event {
        $data['user_id'] = $user->id;

        $event = $this->eventsRepo->create($data);

        $notifyAt = Carbon::parse($event->scheduled_at)->subMinutes($event->remind_before_minutes);

        $notification = EventNotification::create([
            'event_id' => $event->id,
            'scheduled_for' => $notifyAt
        ]);

        SendEventReminderJob::dispatch($notification)->delay($notifyAt);

        return $event;
    }

    public function update(int $id, array $data, User $user): Event {
        $event = $this->eventsRepo->findUserEvent($user->id, $id);

        if (!$event) {
            throw new NotFoundHttpException('Event is not found');
        };

        if ($event->is_completed) {
            throw ValidationException::withMessages([
                'event' => ['Completed event cannot be modified']
            ]);
        }

        return $this->eventsRepo->update($event, $data);
    }

    public function delete($id, User $user): bool {
        $event = $this->eventsRepo->findUserEvent($user->id, $id);

        if (!$event) {
            throw new NotFoundHttpException('Event is not found');
        };

         if ($event->is_completed) {
            throw ValidationException::withMessages([
                'event' => ['Completed event cannot be removed']
            ]);
        }

        return $this->eventsRepo->delete($event);
    }

    public function list(User $user, string $from, string $to): Collection {
        return $this->eventsRepo->getBetweenDates($user->id, $from, $to);
    }

    public function show(User $user, int $id): Event {

         $event = $this->eventsRepo->findUserEvent($user->id, $id);

        if (!$event) {
            throw new NotFoundHttpException('Event is not found');
        }

        return $event;
    }

    public function complete(int $id, User $user): Event {
        $event = $this->eventsRepo->findUserEvent($user->id, $id);

        if (!$event) {
            throw new NotFoundHttpException('Event is not found');
        };

         if ($event->is_completed) {
            throw ValidationException::withMessages([
                'event' => ['Completed event cannot be completed again']
            ]);
        }

        return $this->eventsRepo->update($event, ['is_completed' => true]);
    }
}