<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\ManageStatusController;
use App\Http\Controllers\ManageScheduleController;
use App\Http\Controllers\ManageRelayController;
use App\Http\Controllers\SessionController;
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







Route::resource('/', DashboardController::class);
Route::resource('manage-device', ManageController::class)->middleware('isLogin');
Route::resource('manage-schedule', ManageScheduleController::class);
Route::resource('manage-status', ManageStatusController::class);
Route::resource('manage-relay', ManageRelayController::class);

Route::get('manage-status/updatesensor/{voltage}/{current}/{power}/{energy}/{frequency}/{powerfactor}', [ManageStatusController::class, 'simpansensor']);
Route::get('manage-relay/relay/{value}', [ManageRelayController::class, 'relay']);
Route::get('manage-send/', [ManageRelayController::class, 'send']);
// Route::get('manage-relay/send', 'ManageRelayController@index');
// Route::get('manage-relay/relay', [ManageRelayController::class, 'relay']);
// Route::get('manage-relay/numberrelay', [ManageRelayController::class, 'numberrelay']);




Route::controller(ManageScheduleController::class)->group(function () {
    Route::get('ubahstatus', 'ubahstatus');
    Route::get('kirimstatus', 'kirimstatus');
    Route::get('jam', 'jam');
});

Route::controller(SessionController::class)->group(function () {
    Route::get('sesi', 'index')->middleware('isTamu');
    Route::post('/sesi/login', 'login')->middleware('isTamu');
    Route::get('/sesi/logout', 'logout');
    Route::get('sesi/register', 'register')->middleware('isTamu');
    Route::post('/sesi/create', 'create')->middleware('isTamu');
});






// Route::group([], function () {
//     Route::get('/', [ManageStatusController::class, 'index']);
//     Route::get('/demo', [ManageStatusController::class, 'index']);
//     Route::get('/manage-status/index', [ManageStatusController::class, 'index']);
//     Route::get('/manage-status/ajax', [ManageStatusController::class, 'ajax']);
// });

// Route::controller(ManageStatusController::class)->group(function () {
//     // Checkbox
//     Route::post('form/checkbox/new', 'formCheckbox')->name('form/checkbox/new');
// });
