<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    function CreatePermission()
    {
        $allPermissions = Permission::all();
        return view('admin.rolePermission.createPermission', compact('allPermissions'));
    }
    function PermissionStore(Request $request)
    {
        $permission = Permission::create(['name' => $request->permissionName]);
        return  back()->with('success', 'Permission added successfully.');
    }
    function permissionEdit($id)
    {
        $permission = Permission::find($id);
        return view('admin.rolePermission.permissionEdit', compact('permission'));
    }
    function PermissionUpdate(Request $request, $permissionId)
    {

        Permission::find($permissionId)->update([
            'name' => $request->permissionName,
        ]);
        return redirect()->route('create.permission')->with('success', 'Permission Updated Successfully.');
    }
    function PermissionDelete($id)
    {
        Permission::find($id)->delete();
        return  back()->with('success', 'Permission deleted successfully.');
    }
    function createAssignRole()
    {
        $allPermissions = Permission::all();
        $roles = Role::all();
        return view('admin.rolePermission.createAssignRole', compact('allPermissions', 'roles'));
    }
    function AssignRoleStore(Request $request)
    {
        $request->validate([
            'roleName' => 'required',
            'permissionId' => 'required'
        ], ['permissionId.required' => 'Please Select Permissions.']);
        $role = Role::create(['name' => $request->roleName]);
        $role->givePermissionTo([$request->permissionId]);
        return back()->with('success', 'Created & Assigned Role Successfully.');
    }
    function AssignRolePermissionEdit($roleId)
    {
        $allPermissions = Permission::all();
        $roles = Role::find($roleId);
        return view('admin.rolePermission.roleEditPermission', compact('allPermissions', 'roles'));
    }
    function AssignRolePermissionUpdate(Request $request, $roleId)
    {
        if (Role::where('name', $request->roleName)->exists()) {
            $role = Role::find($roleId);
            $role->syncPermissions($request->permissionId);
            return redirect()->route('create.assign.role')->with('success', 'Assigned Role Successfully.');
        } else {

            Role::find($roleId)->update([
                'name' => $request->roleName,
            ]);
            $role = Role::find($roleId);
            $role->givePermissionTo([$request->permissionId]);
            return redirect()->route('create.assign.role')->with('success', ' & Assigned Role Successfully.');
        }
    }
    function AssignRolePermissionDelete($roleId)
    {
        $role = Role::findOrFail($roleId);
        if (!is_null($role)) {
            $role->delete();
        }
        return redirect()->route('create.assign.role')->with('success', 'Role Deleted Successfully.');
    }
    function createUserRole()
    {
        $users = User::all();
        $roles = Role::all();
        return view('admin.rolePermission.createUserRole', compact('users', 'roles'));
    }
    function assignUserRoleStore(Request $request)
    {
        $users = User::find($request->userId);
        foreach ($users as $role) {
            $role->assignRole([$request->roleId]);
        }
        return back();
    }
    function assignUserRoleEdit($userId)
    {
        $users = User::all();
        $roles = Role::all();
        $singleUser = User::find($userId);
        return view('admin.rolePermission.assignUserRoleEdit', compact('users', 'singleUser', 'roles'));
    }
    function assignUserRoleUpdate(Request $request)
    {
        $users = User::find($request->userId);
        foreach ($users as $userRole) {
            $userRole->syncRoles($request->roleId);
        }
        return redirect()->route('create.user.role')->with('success', 'User Role Updated Successfully.');
    }
}
