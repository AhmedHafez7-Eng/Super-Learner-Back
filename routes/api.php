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

///////////////////////////// Auth Routes  (For All Users) /////////////////////////////
// ------ Public Routes

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::put('/edit_profile/{id}', [AuthController::class, 'edit_profile']);
// ------ Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

///////////////////////////// Student Routes /////////////////////////////

Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);
Route::get('/courseofstu/{id}', [StudentController::class, 'coursestu']);
Route::post('/enrolle', [StudentController::class, 'enrolle']);
Route::post('/ifenrolle', [StudentController::class, 'ifenroll']);
Route::put('/feedback/{id}', [studentcourseController::class, 'feedback']);
///////////////////////////// Instructor Routes /////////////////////////////

Route::get('/instructors', [instructorController::class, 'list']);
Route::post('/upload/{id}', [instructorController::class, 'saveimg']);
Route::get('/courseinfo/{id}', [instructorController::class, 'getone']);
Route::get('/getimage/{id}', [instructorController::class, 'getimageof']);
Route::get('/delete/{id}', [instructorController::class, 'delete']);

Route::post('/uploadimg/{id}', [instructorController::class, 'saveimgcourse']);

///////////////////////////// Courses Routes /////////////////////////////
Route::get('/courses', [coursesController::class, 'listCourse']);
Route::post('/uploadimg/{id}', [coursesController::class, 'saveimgcourse']);
Route::post('/update/{id}', [coursesController::class, 'update']);
Route::get('/course/{id}', [coursesController::class, 'getCourse']);
Route::post('/add', [coursesController::class, 'addcourse']);

///////////////////////////// API Student Courses /////////////////////////////
Route::get('/student-courses', [studentcourseController::class, 'index']);
Route::get('/student-courses/{id}', [studentcourseController::class, 'show']);

///////////////////////////// Posts //////////////////////////////////

Route::get('/posts', [postsController::class, 'index']);
Route::get('/posts/{id}', [postsController::class, 'show']);
Route::post('/posts/{id}', [postsController::class, 'update']);
Route::post('/posts', [postsController::class, 'store']);
Route::delete('/posts/{id}', [postsController::class, 'delete']);

/////////////////////////////  Tests //////////////////////////////////
Route::get('/tests', [TestsController::class, 'index']);
Route::get('/tests/{id}', [TestsController::class, 'show']);
Route::post('/addTest', [TestsController::class, 'store']);
Route::put('/tests/{id}', [TestsController::class, 'update']);
Route::delete('/tests/{id}', [TestsController::class, 'delete']);
/////////////////////////////////////////////////////
//get all tests related to specific course
Route::get('/quiz/{course_id}', [TestsController::class, 'gettest']);
//get collection of questions to each test
Route::get('/ques/{test_id}', [TestsController::class, 'getdetails']);

/////////////////////////////  TestsDetails //////////////////////////////////
Route::get('/testsdetails', [TestDetailsController::class, 'index']);
Route::get('/testsdetails/{id}', [TestDetailsController::class, 'show']);
Route::post('/testsdetails', [TestDetailsController::class, 'addquiz']);
Route::put('/testsdetails/{id}', [TestDetailsController::class, 'update']);
Route::delete('/testsdetails/{id}', [TestDetailsController::class, 'delete']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/////////////////////////////  Payment //////////////////////////////////

Route::post('pay', [FatoorahController::class, 'payOrder']);
// Route::get('pay', [FatoorahController::class, 'payOrder']);
Route::get('call_back', [FatoorahController::class, 'callBack']);
Route::get('error', [FatoorahController::class, 'callBack']);

//////////////////////////////Admin/////////////
Route::get('/delete/instructor/{id}', [instructorController::class, 'destroy']);
Route::get('/delete/course/{id}', [coursesController::class, 'delete']);
Route::get('/delete/student/{id}', [StudentController::class, 'delete']);