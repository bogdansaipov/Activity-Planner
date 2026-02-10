<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\User;
use App\Repositories\Contracts\EventRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EventRepository implements EventRepositoryInterface {
    
 public function create(array $data): Event {
    return Event::create($data);
 }

 public function update(Event $event ,array $data): Event
 {
    $event->update($data);

    return $event->fresh();
 }

 public function delete(Event $event): bool
 {
   return $event->delete();
 }

 public function findUserEvent(int $userId, int $eventId): Event
 {
    return Event::where('user_id', $userId)->where('id', $eventId)->first();
 }

 public function getBetweenDates(int $userId, string $from, string $to): Collection
 {
    return Event::where('user_id', $userId)->whereBetween('scheduled_at', [$from, $to])->orderBy('scheduled_at')->get();
 }
}