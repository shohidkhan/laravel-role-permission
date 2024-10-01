<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller implements HasMiddleware {

    public static function middleware() {
        return [
            new Middleware(middleware: "permission:view permission", only: ['index']),
            new Middleware(middleware: "permission:create permission", only: ['create']),
            new Middleware(middleware: "permission:edit permission", only: ['edit']),
            new Middleware(middleware: "permission:delete permission", only: ['destroy']),
        ];
    }

    //this method shows persmissons page
    public function index() {
        $permissions = Permission::orderBy("created_at", "desc")->paginate(10);
        return view('permissions.list', ["permissions" => $permissions]);
    }

    public function create() {
        return view('permissions.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => "required|unique:permissions|min:3",
        ]);

        if ($validator->passes()) {
            Permission::create([
                "name" => $request->name,
            ]);

            return redirect()->route('permissions.create')->with('success', 'Permission created successfully');

        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

    public function edit($id) {
        $permission = Permission::find($id);
        return view('permissions.edit', ["permission" => $permission]);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            "name" => "required|unique:permissions,name|min:3," . $id,
        ]);

        if ($validator->passes()) {
            $permission = Permission::find($id);
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.edit', ["id" => $id])->with('success', 'Permission updated successfully');
        } else {
            return redirect()->route('permissions.edit', ["id" => $id])->withInput()->withErrors($validator);
        }
    }

    public function destroy($id) {
        $permission = Permission::find($id);
        $permission->delete();
        return redirect()->route('permissions.list')->with('success', 'Permission deleted successfully');
    }
}
