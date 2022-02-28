<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIs\AuthController;
use App\Http\Controllers\APIs\instructorController;
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
    Route::get('/student/{id}', [StudentController::class, 'show']);
    Route::put('/student/{id}', [StudentController::class, 'update']);
    Route::delete('/student/{id}', [StudentController::class, 'destroy']);
});






// ====================== Instructor Routes

Route::get('/instructors', [instructorController::class, 'list']);
Route::post('/upload/{id}', [instructorController::class, 'saveimg']);
Route::get('/courseinfo/{id}', [instructorController::class, 'getone']);
Route::get('/getimage/{id}', [instructorController::class, 'getimageof']);
Route::get('/delete/{id}', [instructorController::class, 'delete']);
Route::post('/uploadimg/{id}', [instructorController::class, 'saveimgcourse']);


// ====================== Courses Routes
Route::get('/courses', [coursesController::class, 'listCourse']);













Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});