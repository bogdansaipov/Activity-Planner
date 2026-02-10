<?php

namespace App\Models\Relations;

use App\Models\Event;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait EventNotificationsRelations {

    public function event(): BelongsTo {
        return $this->belongsTo(Event::class);
    }
}