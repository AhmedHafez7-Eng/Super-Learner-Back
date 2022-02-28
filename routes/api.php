<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIs\instructorController;
use App\Http\Controllers\APIs\TestsController;
use App\Http\Controllers\APIs\TestDetailsController;

use App\Models\User;
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
Route::post('/upload/{id}',[instructorController::class,'saveimg']);
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
