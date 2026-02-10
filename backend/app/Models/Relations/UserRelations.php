<?php

namespace App\Models\Relations;

use App\Models\Event;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait UserRelations {
    # User Relationships

    public function events(): HasMany {
        return $this->hasMany(Event::class, 'user_id');
    }
}