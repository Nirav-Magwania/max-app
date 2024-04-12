<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionController extends Controller
{
    // Role endpoints

    // Get all roles
    public function roleIndex()
    {
        try {
            $roles = Role::all();
            return response()->json($roles);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Create a new role
    public function roleStore(Request $request)
    {
        try {
            $registerRoleData = $request->validate([
                'name' => 'required|string|unique:roles',
            ]);

            $role = Role::create([
                'name' => $registerRoleData['name'],
            ]);

            return response()->json([
                'message' => "New role added successfully: $role->name"
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Update role permissions
    public function roleUpdate(Role $role, Request $request)
    {
        try {
            $request->validate([
                //'name'=>'required|string',
                'permission_ids' => 'required|array'
            ]);

            $existingRolePermissions = $role->permissions()->get();
            $role->permissions()->detach($existingRolePermissions);

            $permissions = Permission::whereIn('id', $request->post('permission_ids'))->get();

            $role->permissions()->attach($permissions);

            return response()->json([
                'message' => 'Role permissions updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Delete a role
    public function roleDestroy(Role $role)
    {
        try {
            $permissions = $role->permissions;
            $role->permissions()->detach($permissions);
            $role->delete();

            return response()->json([
                'message' => "$role->name has been successfully deleted"
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Permission endpoints

    // Get all permissions
    public function permissionIndex()
    {
        try {
            $permissions = Permission::all();
            return response()->json($permissions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Create a new permission
    public function permissionStore(Request $request)
    {
        try {
            $registerPermissionData = $request->validate([
                'name' => 'required|string|unique:permissions,name',
            ]);

            $permission = Permission::create([
                'name' => $registerPermissionData['name'],
            ]);

            return response()->json([
                'message' => "New permission added successfully: $permission->name"
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Delete a permission
    public function permissionDestroy(Permission $permission)
    {
        try {
            $permission->delete();
            return response()->json([
                'message' => "$permission->name has been successfully deleted"
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Attach a role with permissions
    public function attach(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:roles,name',
                'permission_ids' => 'required|array'
            ]);

            $newRole = Role::create([
                'name' => $request->name,
            ]);

            $permissions = Permission::whereIn('id', $request->post('permission_ids'))->get();

            $newRole->permissions()->attach($permissions);

            return response()->json([
                'message' => 'Role and permissions attached successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Detach a permission from a role
    public function detach(Role $role, Permission $permission)
    {
        try {
            if (!$role->permissions()->where('permissions.id', $permission->id)->exists()) {
                return response()->json([
                    'message' => "Permission: $permission->name is not attached with role: $role->name"
                ]);
            }

            $role->permissions()->detach($permission);

            return response()->json([
                'message' => "Permission: $permission->name is detached from role: $role->name"
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Sync permissions for a role
    public function sync(Role $role, Request $request)
    {
        try {
            $permissions = $request->input('permissions');
            $role->permissions()->sync($permissions);

            return response()->json('Permissions synced successfully');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Get permissions for a role
    public function superIndex(Role $role)
    {
        try {
            $permissions = $role->permissions->pluck('name');
            return response()->json([
                "$role->name" => $permissions
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
