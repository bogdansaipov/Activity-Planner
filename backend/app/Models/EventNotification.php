<?php

namespace App\Models;

use App\Models\Relations\EventNotificationsRelations;
use Illuminate\Database\Eloquent\Model;

class EventNotification extends Model
{

    use EventNotificationsRelations;

      protected $fillable = [
        'event_id',
        'scheduled_for',
        'sent_at',
    ];

    protected $casts = [
        'scheduled_for' => 'datetime',
        'sent_at' => 'datetime',
    ];
}
