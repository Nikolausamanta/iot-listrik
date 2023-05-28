<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\ManageStatusController;
use App\Http\Controllers\ManageScheduleController;
use Illuminate\Support\Facades\Route;

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



// Route::get('/', function () {
//     return view('dashboard/index');
// });



Route::resource('/', DashboardController::class);
Route::resource('manage-device', ManageController::class);
Route::resource('manage-status', ManageStatusController::class);
Route::resource('manage-schedule', ManageScheduleController::class);
