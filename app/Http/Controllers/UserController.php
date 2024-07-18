<?php

namespace App\Http\Controllers;

use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;

/**
 * @group User Management
 *
 * APIs for managing users
 */
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Get all users
     *
     * Returns a list of all users.
     *
     * @authenticated
     * @response 200 {
     *  "code": 200,
     *  "message": "OK",
     *  "data": [
     *      {
     *          "id": 1,
     *          "name": "Test User",
     *          "email": "test@example.com",
     *          "created_at": "2021-01-01T00:00:00.000000Z",
     *          "updated_at": "2021-01-01T00:00:00.000000Z"
     *      }
     *  ]
     * }
     */
    public function index()
    {
        return $this->userService->all()->toJson();
    }

    /**
     * Get a user by ID
     *
     * Returns the details of a specific user by their ID.
     *
     * @authenticated
     * @urlParam id integer required The ID of the user. Example: 1
     *
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
     * @response 404 {
     *  "message": "User not found"
     * }
     */
    public function show($id): JsonResponse
    {
        return $this->userService->findOrFail($id)->toJson();
    }
}
