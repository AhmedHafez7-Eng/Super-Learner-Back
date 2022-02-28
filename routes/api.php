<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIs\AuthController;
use App\Http\Controllers\APIs\instructorController;
use App\Http\Controllers\APIs\TestsController;
use App\Http\Controllers\APIs\TestDetailsController;
use App\Http\Controllers\APIs\coursesController;
use App\Http\Controllers\APIs\StudentController;
use App\Models\User;
use App\Models\Course;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// ====================== Auth Routes  (For All Users)
// ------ Public Routes

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ------ Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});


// ====================== Student Routes
// ------ Public Routes


// ------ Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);

    // Route::apiResource('students', StudentController::class);
});


// ====================== Instructor Routes

Route::get('/instructors', [instructorController::class, 'list']);
Route::post('/upload/{id}', [instructorController::class, 'saveimg']);
Route::get('/courseinfo/{id}', [instructorController::class, 'getone']);
Route::get('/getimage/{id}', [instructorController::class, 'getimageof']);
Route::get('/delete/{id}', [instructorController::class, 'delete']);
Route::post('/uploadimg/{id}', [instructorController::class, 'saveimgcourse']);


// ====================== Courses Routes
Route::get('/courses',[coursesController::class,'listCourse']);
Route::post('/uploadimg/{id}',[coursesController::class,'saveimgcourse']);
Route::post('/update/{id}', [coursesController::class, 'update']);

// =========================================tests routes========================================================

Route::get('/tests',[TestsController::class,'index']);
Route::get('/tests/{id}',[TestsController::class,'show']);
Route::post('/tests',[TestsController::class,'create']);
Route::put('/tests/{id}', [TestsController::class, 'update']);
Route::delete('/tests/{id}', [TestsController::class, 'delete']);
// ========================================= testsDetails routes========================================================

Route::get('/testsdetails',[TestDetailsController::class,'index']);
Route::get('/testsdetails/{id}',[TestDetailsController::class,'show']);
Route::post('/testsdetails',[TestDetailsController::class,'create']);
Route::put('/testsdetails/{id}', [TestDetailsController::class, 'update']);
Route::delete('/testsdetails/{id}', [TestDetailsController::class, 'delete']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

