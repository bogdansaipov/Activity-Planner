<?php

namespace App\Models\Relations;

use App\Models\EventNotification;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait EventsRelations {

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function notifications(): HasMany {
        return $this->hasMany(EventNotification::class);
    }
}