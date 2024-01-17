<?php

namespace App\Http\Controllers;

use App\Domain\Admin\Requests\StoreAdminRequest;
use App\Domain\Admin\Requests\UpdateAdminRequest;
use App\Http\Requests\StoreTenantRequest;
use App\Http\Requests\UpdateTenantRequest;
use App\Models\Admin;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    /**
     * Create an admin.
     */
    public function store(StoreAdminRequest $request): JsonResponse
    {
        $tenant = Tenant::create(['id' => $request->input('name')]);

        $tenant->domains()->create($request->only(['domain']));

        return response()->json([
            'message' => __('Admin created successfully'),
        ]);
    }

    /**
     * List admins.
     */
    public function index(): JsonResponse
    {
        $tenants = Tenant::all();

        return response()->json([
            'resources' => $tenants,
        ]);
    }

    /**
     * Show an admin.
     */
    public function show(Tenant $tenant): JsonResponse
    {
        return response()->json([
            'resource' => $tenant,
        ]);
    }

    /**
     * Update an admin.
     */
    public function update(UpdateAdminRequest $request, Tenant $tenant): JsonResponse
    {
        $tenant->update(['id' => $request->input('name')]);

        return response()->json([
            'message' => __('Admin updated successfully'),
        ]);
    }

    /**
     * Delete an admin.
     */
    public function delete(Admin $admin): JsonResponse
    {
        $admin->delete();

        return response()->json([
            'message' => __('Admin deleted successfully'),
        ]);
    }
}
