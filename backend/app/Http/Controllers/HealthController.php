<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

class HealthController extends Controller
{
    #[OA\Get(
        path: "/api/health",
        operationId: "healthCheck",
        tags: ["System"],
        summary: "Health check"
    )]
    #[OA\Response(
        response: 200,
        description: "API is working"
    )]
    public function index()
    {
        return response()->json(['status' => 'ok']);
    }
}