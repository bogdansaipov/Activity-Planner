<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Smart Planner API",
    version: "1.0.0",
    description: "API for managing events and Telegram reminders"
)]
#[OA\Server(
    url: "http://localhost:8080",
    description: "Local server"
)]
class OpenApi {}