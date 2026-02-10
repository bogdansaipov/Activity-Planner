<?php

namespace App\Docs\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "RegisterRequest",
    required: ["username","name","password"],
    properties: [
        new OA\Property(property: "username", type: "string", example: "john123"),
        new OA\Property(property: "name", type: "string", example: "John Doe"),
        new OA\Property(property: "password", type: "string", format: "password", example: "secret123"),    ]
)]

#[OA\Schema(
    schema: "LoginRequest",
    required: ["username","password"],
    properties: [
        new OA\Property(property: "username", type: "string", example: "john123"),
        new OA\Property(property: "password", type: "string", format: "password", example: "secret123"),
    ]
)]

#[OA\Schema(
    schema: "AuthResponse",
    properties: [
        new OA\Property(property: "token", type: "string", example: "1|laravel_sanctum_token_here"),
        new OA\Property(
            property: "user",
            properties: [
                new OA\Property(property: "id", type: "integer", example: 1),
                new OA\Property(property: "name", type:"string", example:"John Doe"),
                new OA\Property(property: "username", type: "string", example: "john123"),
                new OA\Property(property: "telegram_chat_id", type: "string", example: "123456789"),
                new OA\Property(property: "timezone", type: "string", example: "Asia/Tashkent"),
            ],
            type: "object"
        )
    ],
    type: "object"
)]

class AuthSchemas {}