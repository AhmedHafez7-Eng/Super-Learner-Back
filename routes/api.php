<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIs\AuthController;
use App\Http\Controllers\APIs\instructorController;
use App\Http\Controllers\APIs\TestsController;
use App\Http\Controllers\APIs\TestDetailsController;
use App\Http\Controllers\APIs\coursesController;
use App\Http\Controllers\APIs\postsController;
use App\Http\Controllers\APIs\studentcourseController;

use App\Http\Controllers\APIs\StudentController;
use App\Http\Controllers\FatoorahController;
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
//Route::group(['middleware' => ['auth:sanctum']], function () {
Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);

// Route::apiResource('students', StudentController::class);
//});


// ====================== Instructor Routes

Route::get('/instructors', [instructorController::class, 'list']);
Route::post('/upload/{id}', [instructorController::class, 'saveimg']);
Route::get('/courseinfo/{id}', [instructorController::class, 'getone']);
Route::get('/getimage/{id}', [instructorController::class, 'getimageof']);
Route::get('/delete/{id}', [instructorController::class, 'delete']);

Route::post('/uploadimg/{id}', [instructorController::class, 'saveimgcourse']);
/////////////////////////////////////////////////////////////
// ====================== Courses Routes
Route::get('/courses', [coursesController::class, 'listCourse']);
Route::post('/uploadimg/{id}', [coursesController::class, 'saveimgcourse']);
Route::post('/update/{id}', [coursesController::class, 'update']);
Route::get('/course/{id}', [coursesController::class, 'getCourse']);


/////////API Student Courses /////////////////////
Route::get('/student-courses', [studentcourseController::class, 'index']);
Route::get('/student-courses/{id}', [studentcourseController::class, 'show']);
// Route::post('/scores/{id}', [studentcourseController::class, 'update']);
// Route::post('/scores', [studentcourseController::class, 'store']);
// Route::delete('/scores/{id}', [studentcourseController::class, 'delete']);

Route::get('/posts', [postsController::class, 'index']);
Route::get('/posts/{id}', [postsController::class, 'show']);
Route::post('/posts/{id}', [postsController::class, 'update']);
Route::post('/posts', [postsController::class, 'store']);
Route::delete('/posts/{id}', [postsController::class, 'delete']);



// =========================================tests routes========================================================

Route::get('/tests', [TestsController::class, 'index']);
Route::get('/tests/{id}', [TestsController::class, 'show']);
Route::post('/tests', [TestsController::class, 'store']);
Route::put('/tests/{id}', [TestsController::class, 'update']);
Route::delete('/tests/{id}', [TestsController::class, 'delete']);
/////////////////////////////////////////////////////
//get all tests related to specific course
Route::get('/quiz/{course_id}', [TestsController::class, 'gettest']);
//get collection of questions to each test
Route::get('/ques/{test_id}', [TestsController::class, 'getdetails']);

// ========================================= testsDetails routes========================================================

Route::get('/testsdetails', [TestDetailsController::class, 'index']);
Route::get('/testsdetails/{id}', [TestDetailsController::class, 'show']);
Route::post('/testsdetails', [TestDetailsController::class, 'store']);
Route::put('/testsdetails/{id}', [TestDetailsController::class, 'update']);
Route::delete('/testsdetails/{id}', [TestDetailsController::class, 'delete']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();


/////////////////////////////  payment //////////////////////////////////

Route::post('pay',[FatoorahController::class, 'payOrder']);
Route::get('pay', [FatoorahController::class, 'payOrder']);
Route::get('call_back', [FatoorahController::class, 'callBack']);
});
