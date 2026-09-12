<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function edit($roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::all();

        return view('roles.permissions', compact('role', 'permissions'));
    }

    public function update(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permissions ?? []);

        // return redirect()->back()->with('success', 'Permissions updated!');
        return redirect()->back()->with('success', 'Permissions updated successfully!');
    }
}

