<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permissions;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * List all roles with their permission count.
     */
    public function index()
    {
        try {
            $roles = Role::all();
            $permissionCounts = RolePermission::select('role_id', DB::raw('count(*) as total'))
                ->groupBy('role_id')
                ->pluck('total', 'role_id');

            return view('admin.roles.index', compact('roles', 'permissionCounts'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|string|max:255|unique:roles,role',
        ]);

        try {
            Role::create(['role' => $request->role]);
            session()->flash('success', 'Role created successfully');
            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    /**
     * Show the permission assignment screen for a role.
     */
    public function edit($id)
    {
        try {
            $role = Role::find($id);
            if (empty($role)) {
                session()->flash('error', 'Role not found');
                return redirect()->route('roles.index');
            }

            $permissions = Permissions::orderBy('id', 'ASC')->get();
            $assigned = RolePermission::where('role_id', $id)->pluck('permissions_id')->toArray();

            return view('admin.roles.edit', compact('role', 'permissions', 'assigned'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    /**
     * Save the permissions assigned to a role.
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if (empty($role)) {
            session()->flash('error', 'Role not found');
            return redirect()->route('roles.index');
        }

        $request->validate([
            'role' => 'required|string|max:255',
        ]);

        try {
            $role->role = $request->role;
            $role->save();

            $permissionIds = $request->input('permissions_id', []);
            if (!is_array($permissionIds)) {
                $permissionIds = [];
            }

            DB::beginTransaction();

            RolePermission::where('role_id', $role->id)->delete();

            $rows = [];
            foreach ($permissionIds as $permissionId) {
                $rows[] = [
                    'role_id' => $role->id,
                    'permissions_id' => $permissionId,
                    'is_active' => 1,
                    'is_deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($rows)) {
                RolePermission::insert($rows);
            }

            DB::commit();

            session()->flash('success', 'Permissions updated successfully');
            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::find($id);

            if (empty($role)) {
                session()->flash('error', 'Role not found');
                return redirect()->route('roles.index');
            }

            // Never allow deleting Super Admin or a role that is in use.
            if ((int) $role->id === 1) {
                session()->flash('error', 'Super Admin role cannot be deleted.');
                return redirect()->route('roles.index');
            }

            if ($role->adminiy()->exists()) {
                session()->flash('error', 'This role is assigned to one or more users and cannot be deleted.');
                return redirect()->route('roles.index');
            }

            RolePermission::where('role_id', $role->id)->delete();
            $role->delete();

            session()->flash('success', 'Role deleted successfully');
            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Request :" . $th->getMessage());
            throw $th;
        }
    }
}
