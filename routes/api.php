<?php

use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseLanguageController;
use App\Http\Controllers\Admin\CourseLevelController;
use App\Http\Controllers\Admin\CourseSubcategoryController;
use App\Http\Controllers\Admin\InstructorRequestController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Instructor\CourseController;
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

    Route::put('/profile/{user}', [ProfileController::class, 'update']);
    Route::put('/profile/{user}/update-password', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/{user}/update-image', [ProfileController::class, 'updateImage']);

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/instructor/requests', [InstructorRequestController::class, 'index']);
    });


    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::apiResource('/courses/languages', CourseLanguageController::class);
        Route::apiResource('/courses/levels', CourseLevelController::class);
        Route::apiResource('/courses/categories', CourseCategoryController::class);
        Route::get('/courses/categories/{category}/subcategories', [CourseSubcategoryController::class, 'index']);
        Route::get('/courses/categories/{category}/subcategories/{subcategory}', [CourseSubcategoryController::class, 'show']);
        Route::post('/courses/categories/{category}/subcategories', [CourseSubcategoryController::class, 'store']);
        Route::put('/courses/categories/{category}/subcategories/{subcategory}', [CourseSubcategoryController::class, 'update']);
        Route::delete('/courses/categories/{category}/subcategories/{subcategory}', [CourseSubcategoryController::class, 'destroy']);
    });

    Route::group(['middleware' => 'instructor'], function () {
        Route::get('/instructor/courses', [CourseController::class, 'index']);
        Route::get('/instructor/courses/{course}', [CourseController::class, 'show']);
        Route::get('/instructor/courses/{course}/step2', [CourseController::class, 'step2']);
        Route::post('/instructor/courses', [CourseController::class, 'store']);
        Route::post('/instructor/courses/{course}', [CourseController::class, 'updateStep1']);
        Route::post('/instructor/courses/{course}/step2', [CourseController::class, 'updateStep2']);
    });

    Route::group(['middleware' => 'student', 'prefix' => 'admin'], function () {
        Route::put('/instructor/requests/{user}', [InstructorRequestController::class, 'update']);
        Route::post('/instructor/requests/{user}', [InstructorRequestController::class, 'becomeInstructor']);
    });
});
