<?php
use App\Http\Controllers\FatoorahController;
use Illuminate\Support\Facades\Route;
// use app\http\controllers\mailController;
// use App\Http\Controllers\mailController;

use App\Http\Controllers\mailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::get('mail', [StudentController::class, 'enrolle']);
// Route::get('mail', [StudentController::class, 'enrolle']);

Route::post('pay', [FatoorahController::class, 'payOrder']);