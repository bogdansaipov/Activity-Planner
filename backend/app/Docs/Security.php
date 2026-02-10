<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

#[OA\SecurityScheme(
    securityScheme: "sanctum",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
class Security {}