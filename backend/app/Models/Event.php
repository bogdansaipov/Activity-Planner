<?php

namespace App\Models;

use App\Models\Relations\EventsRelations;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    use EventsRelations;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'scheduled_at',
        'duration_minutes',
        'remind_before_minutes',
        'is_completed'
    ];

     protected $casts = [
        'scheduled_at' => 'datetime',
        'is_completed' => 'boolean',
    ];
}
