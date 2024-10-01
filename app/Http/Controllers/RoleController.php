<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware {

    public static function middleware() {
        return [
            new Middleware(middleware: "permission:view role", only: ['index']),
            new Middleware(middleware: "permission:create role", only: ['create']),
            new Middleware(middleware: "permission:edit role", only: ['edit']),
            new Middleware(middleware: "permission:delete role", only: ['destroy']),
        ];
    }
    //

    function index() {
        $roles = Role::orderBy("created_at", "desc")->paginate(10);
        return view('roles.list', ["roles" => $roles]);
    }
    function create() {
        $permissions = Permission::orderBy('created_at', 'desc')->get();
        return view('roles.create', ["permissions" => $permissions]);
    }
    function store(Request $request) {
        // dd($request->all());
        $request->validate([
            "name" => "required|unique:roles|min:3",
        ]);
        $role = Role::create([
            "name" => $request->name,
        ]);
        if (!empty($request->permissions)) {
            foreach ($request->permissions as $name) {
                $role->givePermissionTo($name);
            }
        }
        return redirect()->route("roles.create")->with("success", "Role created successfully");
    }
    function edit($id) {
        $role = Role::find($id);
        $roleHasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('created_at', 'desc')->get();
        return view("roles.edit", [
            "role" => $role,
            "roleHasPermissions" => $roleHasPermissions,
            "permissions" => $permissions,
        ]);
    }
    function update($id, Request $request) {

        $validator = Validator::make($request->all(), [
            "name" => "required|unique:roles,name," . $id,
        ]);

        if ($validator->passes()) {
            $role = Role::find($id);
            $role->name = $request->name;
            $role->save();
            if (!empty($request->permissions)) {
                $role->syncPermissions($request->permissions);
            } else {
                $role->syncPermissions([]);
            }

            return redirect()->route("roles.list", ["id" => $id])->with("success", "Role updated successfully");
        } else {
            return redirect()->route("roles.edit", ["id" => $id])->withInput()->withErrors($validator);
        }

    }
    function destroy($id) {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route("roles.list")->with("success", "Role deleted successfully");
    }
}
