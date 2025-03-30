<?php

use App\Http\Controllers\Admin\InstructorRequestController;
use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return response()->json(['message' => 'Hello World!'], 200);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
// admin
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/users', function () {
        return User::select('id', 'name', 'email', 'role')->get();
    });
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/instructor/requests', [InstructorRequestController::class, 'index']);
    });

    Route::group(['middleware' => 'student', 'prefix' => 'admin'], function () {
        Route::put('/instructor/requests/{user}', [InstructorRequestController::class, 'update']);
    });
});
