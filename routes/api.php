<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIs\instructorController;
use App\Http\Controllers\APIs\coursesController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/instructors',[instructorController::class,'list']);
Route::post('/register', [instructorController::class, 'register']);
Route::post('/login', [instructorController::class, 'login']);
Route::post('/upload/{id}',[instructorController::class,'saveimg']);
Route::get('/courseinfo/{id}',[instructorController::class,'getone']);
Route::get('/getimage/{id}',[instructorController::class,'getimageof']);
Route::get('/delete/{id}', [instructorController::class, 'delete']);
Route::post('/uploadimg/{id}',[instructorController::class,'saveimgcourse']);
/////////////////////////////////////////////////////////////
Route::get('/courses',[coursesController::class,'listCourse']);