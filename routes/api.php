<?php

use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\CourseLanguageController;
use App\Http\Controllers\Admin\CourseLevelController;
use App\Http\Controllers\Admin\CourseSubcategoryController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\InstructorRequestController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CoursePageController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Instructor\CourseChapterController;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Instructor\CourseLessonControlller;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\EnrollmentController;
use App\Http\Controllers\Student\WatchHistoryController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/home', function () {
    return response()->json(['message' => 'Hello World!'], 200);
});

// courses
Route::get('/courses', [CoursePageController::class, 'index']);
Route::get('/courses/{course}', [CoursePageController::class, 'show']);

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

    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::apiResource('/courses/languages', CourseLanguageController::class);
        Route::apiResource('/courses/levels', CourseLevelController::class);
        Route::apiResource('/courses/categories', CourseCategoryController::class);
        Route::get('/courses/categories/{category}/subcategories', [CourseSubcategoryController::class, 'index']);
        Route::get('/courses/categories/{category}/subcategories/{subcategory}', [CourseSubcategoryController::class, 'show']);
        Route::post('/courses/categories/{category}/subcategories', [CourseSubcategoryController::class, 'store']);
        Route::put('/courses/categories/{category}/subcategories/{subcategory}', [CourseSubcategoryController::class, 'update']);
        Route::delete('/courses/categories/{category}/subcategories/{subcategory}', [CourseSubcategoryController::class, 'destroy']);
        Route::get('/courses', [AdminCourseController::class, 'index']);
        // need to finish
        Route::put('/courses/{course}/approved', [AdminCourseController::class, 'updateApproved']);
        Route::put('/courses/{course}/status', [AdminCourseController::class, 'updateStatus']);

        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);

        Route::get('/settings', [SettingsController::class, 'index']);
        Route::post('/settings', [SettingsController::class, 'store']);

        Route::get('/instructor/requests', [InstructorRequestController::class, 'index']);
        Route::put('/instructor/requests/{user}', [InstructorRequestController::class, 'update']);

        Route::group(['prefix' => 'sections'], function () {
            Route::apiResource('/hero', HeroController::class);
            Route::post('/hero/update/{hero}', [HeroController::class, 'updateHero']);
        });
    });

    Route::group(['middleware' => 'instructor'], function () {
        Route::get('/instructor/courses', [CourseController::class, 'index']);
        Route::get('/instructor/courses/{course}', [CourseController::class, 'show']);
        Route::get('/instructor/courses/{course}/step2', [CourseController::class, 'step2']);
        Route::post('/instructor/courses', [CourseController::class, 'store']);
        Route::post('/instructor/courses/{course}', [CourseController::class, 'updateStep1']);
        Route::post('/instructor/courses/{course}/step2', [CourseController::class, 'updateStep2']);
        Route::post('/instructor/courses/{course}/step3', [CourseController::class, 'updateStep3']);
        Route::apiResource('/instructor/courses/{course}/chapters', CourseChapterController::class);
        Route::post('/instructor/courses/{course}/chapters/{chapter}/order', [CourseChapterController::class, 'orderLessons']);
        Route::apiResource('/instructor/courses/{course}/chapters/{chapter}/lessons', CourseLessonControlller::class);
    });

    Route::group(['middleware' => 'student'], function () {
        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart', [CartController::class, 'store']);
        Route::delete('/cart/{cart}', [CartController::class, 'destroy']);
        Route::post('/order', [OrderController::class, 'store']);
        Route::get('/order/{course}', [OrderController::class, 'hasCourseInOrderItems']);
        Route::group(['prefix' => 'student'], function () {
            Route::get('/enrollments', [EnrollmentController::class, 'index']);
            Route::get('/enrollments/{course}/get-video/{lesson}', [EnrollmentController::class, 'getVideo']);
            Route::get('/enrollments/{slug}', [EnrollmentController::class, 'show']);
            Route::post('/requests/{user}', [InstructorRequestController::class, 'becomeInstructor']);
            Route::get('/watch-history', [WatchHistoryController::class, 'index']);
            Route::post('/watch-history', [WatchHistoryController::class, 'store']);
        });
    });
});
