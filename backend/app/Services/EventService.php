<?php

namespace App\Services;

use App\Repositories\Contracts\EventRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class EventService
{
    public function __construct(
        private  EventRepositoryInterface $eventRepo
    ) {}

    
}