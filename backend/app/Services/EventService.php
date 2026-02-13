<?php

namespace App\Services;

use App\Jobs\SendEventReminderJob;
use App\Models\Event;
use App\Models\User;
use App\Repositories\Contracts\EventRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
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

        $reminderTime = $event->scheduled_at
        ->copy()
        ->subMinutes($event->remind_before_minutes);

        if ($reminderTime->isFuture()) {
        SendEventReminderJob::dispatch($event)
            ->delay($reminderTime);
        }

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