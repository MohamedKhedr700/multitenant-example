<?php

namespace App\Http\Controllers;

use App\Domain\User\Requests\StoreUserRequest;
use App\Domain\User\Requests\UpdateUserRequest;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Create a user.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        return response()->json([
            'message' => __('User created successfully'),
        ]);
    }

    /**
     * List users.
     */
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json([
            'resources' => $users,
        ]);
    }

    /**
     * Show a user.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'resource' => $user,
        ]);
    }

    /**
     * Update a user.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        return response()->json([
            'message' => __('User updated successfully'),
        ]);
    }

    /**
     * Delete a user.
     */
    public function delete(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'message' => __('User deleted successfully'),
        ]);
    }
}
