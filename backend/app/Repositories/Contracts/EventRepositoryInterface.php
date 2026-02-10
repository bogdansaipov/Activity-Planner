<?php

namespace App\Repositories\Contracts;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

interface EventRepositoryInterface {
    public function create(array $data): Event;
    public function update(Event $event, array $data): ?Event;
    public function delete(Event $event): bool;
    public function findUserEvent(int $userId, int $eventId): Event;
    public function getBetweenDates(int $userId, string $from, string $to): Collection;
}

