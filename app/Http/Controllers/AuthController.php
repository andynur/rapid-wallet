<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Authentication
 *
 * APIs for user authentication
 */
class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Login
     *
     * Authenticates a user and returns an access token.
     *
     * @param LoginRequest $request
     * @response 200 {
     *  "code": 200,
     *  "message": "Login Success",
     *  "data": {
     *      "name": "Test User",
     *      "access_token": "token",
     *      "token_type": "Bearer"
     *  }
     *  "errors": null
     * }
     * @response 401 {
     *  "code": 401,
     *  "message": "Invalid credentials",
     * }
     * @response 422 {
     *  "message": "... field is required.",
     *  "errors": {},
     * }
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->userService->login($request->only('email', 'password'))->toJson();
    }

    /**
     * Logout
     *
     * Logs out the authenticated user and invalidates the access token.
     *
     * @authenticated
     * @response 200 {
     *  "code": 200,
     *  "message": "Logged out successfully",
     *  "data": []
     *  "errors": null
     * }
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return responseJson('Logged out successfully');
    }

    /**
     * Register
     *
     * Registers a new user and returns an access token.
     *
     * @param RegisterRequest $request
     * @response 201 {
     *  "code": 201,
     *  "message": "OK",
     *  "data": {
     *    "id": 4
     *    "name": "New User",
     *    "email": "new@example.com",
     *    "updated_at": "2024-07-17T16:03:00.000000Z",
     *    "created_at": "2024-07-17T16:03:00.000000Z",
     *  }
     * }
     * @response 422 {
     *  "message": "... field is required.",
     *  "errors": {},
     * }
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->userService->register($request->all())->toJson();
    }

    /**
     * User Info
     *
     * Returns the authenticated user's details.
     *
     * @authenticated
     * @response 200 {
     *  "code": 200,
     *  "message": "OK",
     *  "data": {
     *      "id": 1,
     *      "name": "Test User",
     *      "email": "test@example.com",
     *      "created_at": "2021-01-01T00:00:00.000000Z",
     *      "updated_at": "2021-01-01T00:00:00.000000Z"
     *  }
     * }
     */
    public function user(Request $request): JsonResponse
    {
        return responseJson('OK', $request->user());
    }
}
