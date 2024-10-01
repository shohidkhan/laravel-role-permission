<?php

use App\Http\Controllers\ArticaleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get("/permissions/list", [PermissionController::class, "index"])->name("permissions.list");
    Route::get("/permissions/create", [PermissionController::class, "create"])->name("permissions.create");
    Route::get("/permissions/edit/{id}", [PermissionController::class, "edit"])->name("permissions.edit");
    Route::post("/permissions/store", [PermissionController::class, "store"])->name("permissions.store");
    Route::post("/permissions/update/{id}", [PermissionController::class, "update"])->name("permissions.update");
    Route::get("/permissions/destroy/{id}", [PermissionController::class, "destroy"])->name("permissions.destroy");

    //roles route
    Route::get("/roles/list", [RoleController::class, "index"])->name("roles.list");
    Route::get("/roles/create", [RoleController::class, "create"])->name("roles.create");
    Route::get("/roles/edit/{id}", [RoleController::class, "edit"])->name("roles.edit");
    Route::post("/roles/store", [RoleController::class, "store"])->name("roles.store");
    Route::post("/roles/update/{id}", [RoleController::class, "update"])->name("roles.update");

    Route::delete("/roles/destroy/{id}", [RoleController::class, "destroy"])->name("roles.destroy");

    //articles routes

    // Route::get("/articles/create", [ArticaleController::class, "create"])->name("articles.create");

    // Route::post("/articles/store", [ArticaleController::class, "store"])->name("articles.store");

    Route::resource("articles", ArticaleController::class);
    Route::resource("users", UserController::class);
});

require __DIR__ . '/auth.php';
