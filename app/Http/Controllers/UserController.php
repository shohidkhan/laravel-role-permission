<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller implements HasMiddleware {
    public static function middleware() {
        return [
            new Middleware(middleware: "permission:view user", only: ['index']),
            // new Middleware(middleware: "permission:create user", only: ['create']),
            new Middleware(middleware: "permission:edit user", only: ['edit']),
            new Middleware(middleware: "permission:delete user", only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
        $users = User::latest()->paginate(10);
        return view('users.list', ["users" => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        //
        $user = User::find($id);
        $roles = Role::orderBy("name", "asc")->get();
        $userHasRoles = $user->roles->pluck("id");
        return view('users.edit', compact("user", "roles", "userHasRoles"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //

        $user = User::find($id);

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email|unique:users,email," . $id,
        ]);

        if ($validator->passes()) {

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            $user->syncRoles($request->roles);

            return redirect()->route("users.index")->with("success", "User updated successfully");
        } else {

            return redirect()->route("users.edit", ["id" => $id])->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
