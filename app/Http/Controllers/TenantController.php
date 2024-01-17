<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenantRequest;
use App\Http\Requests\UpdateTenantRequest;
use App\Models\Tenant;
use Illuminate\Http\JsonResponse;

class TenantController extends Controller
{
    /**
     * Create tenant.
     */
    public function store(StoreTenantRequest $request): JsonResponse
    {
        $tenant = Tenant::create(['id' => $request->input('name')]);

        $tenant->domains()->create($request->only(['domain']));

        return response()->json([
            'message' => __('Tenant created successfully'),
        ]);
    }

    /**
     * List tenants.
     */
    public function index(): JsonResponse
    {
        $tenants = Tenant::all();

        return response()->json([
            'resources' => $tenants,
        ]);
    }

    /**
     * Show a tenant.
     */
    public function show(Tenant $tenant): JsonResponse
    {
        return response()->json([
            'resource' => $tenant,
        ]);
    }

    /**
     * Update a tenant.
     */
    public function update(UpdateTenantRequest $request, Tenant $tenant): JsonResponse
    {
        $tenant->update(['id' => $request->input('name')]);

        return response()->json([
            'message' => __('Tenant updated successfully'),
        ]);
    }

    /**
     * Delete a tenant.
     */
    public function delete(Tenant $tenant): JsonResponse
    {
        $tenant->delete();

        return response()->json([
            'message' => __('Tenant deleted successfully'),
        ]);
    }
}
