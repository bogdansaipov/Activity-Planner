<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    
    #[OA\Post(
        path: "/api/v1/auth/register",
        summary: "Register new user",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/RegisterRequest")
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "User registered",
                content: new OA\JsonContent(ref: "#/components/schemas/AuthResponse")
            ),
            new OA\Response(response: 422, description: "Validation error")
        ]
    )]
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return response()->json([
            'user' => new UserResource($result['user']),
            'token' => $result['token']
        ], 201);
    }

       
    #[OA\Post(
        path: "/api/v1/auth/login",
        summary: "Login new user",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/LoginRequest")
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "User logged in",
                content: new OA\JsonContent(ref: "#/components/schemas/AuthResponse")
            ),
            new OA\Response(response: 401, description: "Invalid Credentials")
        ]
    )]
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login(
            $request->validated()['username'],
            $request->validated()['password']
        );

        return response()->json([
            'user' => new UserResource($result['user']),
            'token' => $result['token']
        ]);
    }

    #[OA\Post(
    path: "/api/v1/auth/logout",
    summary: "Logout current user",
    security: [["sanctum" => []]],
    tags: ["Auth"],
    responses: [
        new OA\Response(
            response: 200,
            description: "Logged out",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "message", type: "string", example: "Successfully logged out")
                ]
            )
        ),
        new OA\Response(response: 401, description: "Unauthenticated")
    ]
)]
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}