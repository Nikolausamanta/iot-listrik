<?php

use Carbon\Carbon;
use App\Models\TimerModel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TimerController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\AnalyzeController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AllDeviceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManageDeviceController;
use App\Http\Controllers\ManageRelayController;
use App\Http\Controllers\ManageStatusController;
use App\Http\Controllers\ManageScheduleController;
use App\Models\ManageStatusModel;

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

Route::get('manage-device/show-mac', [ManageDeviceController::class, 'getData']);

Route::get('add-device', [AddDeviceController::class, 'index']);
Route::get('show-mac', [AddDeviceController::class, 'getData']);


Route::get('manage-status/{device_id}', [ManageStatusController::class, 'tampil'])->name('manage-status.tampil');
Route::get('manage-schedule/{device_id}', [ManageScheduleController::class, 'tampil'])->name('manage-schedule.tampil');
Route::get('manage-countdown/{device_id}', [TimerController::class, 'tampil'])->name('manage-countdown.tampil');

Route::get('/timers/{device_id}', [TimerController::class, 'tampil'])->name('timers.tampil');
Route::post('/timers', [TimerController::class, 'store'])->name('timers.store');
Route::post('/timers/{timer}/start', [TimerController::class, 'start'])->name('timers.start');
Route::post('/timers/{timer}/cancel', [TimerController::class, 'cancel'])->name('timers.cancel');
Route::post('/timers/{timer}/update-switch', [TimerController::class, 'updateSwitch'])->name('timers.updateSwitch');


// Route::get('/timers', 'TimerController@index')->name('timers.index');
// Route::post('/timers', 'TimerController@store')->name('timers.store');
// Route::post('/timers/{timer}/cancel', 'TimerController@cancel')->name('timers.cancel');
// Route::get('/timers/check-expired', 'TimerController@checkExpiredTimers')->name('timers.checkExpired');


// Route::middleware('isLogin')->group(function () {
Route::resource('/', DashboardController::class);
Route::resource('room', RoomController::class);
Route::resource('alldevice', AllDeviceController::class);
Route::resource('manage-device', ManageDeviceController::class);

// Route::resource('alldevice/create', [ManageRelayController::class, 'create']);

Route::resource('analyze', AnalyzeController::class);
Route::get('analyze/{device_id}', [AnalyzeController::class, 'tampil']);

Route::resource('manage-schedule', ManageScheduleController::class);
Route::resource('manage-status', ManageStatusController::class);
Route::resource('manage-relay', ManageRelayController::class);
Route::resource('manage-countdown', TimerController::class);
Route::get('analyze/get/allpowerchart', [AnalyzeController::class, 'getPowerChart']);
// Route::get('analyze/get/allpowercard', [AnalyzeController::class, 'getPowerChart']);
Route::get('analyze/get/kwh', [AnalyzeController::class, 'getTotalKwh']);
Route::get('analyze/get/kwhmonth', [AnalyzeController::class, 'getTotalKwhPerMonth']);
Route::get('analyze/get/forecast', [AnalyzeController::class, 'forecast']);

// Route::get('manage-relay/send', 'ManageRelayController@index');
// Route::get('manage-relay/relay', [ManageRelayController::class, 'relay']);
// Route::get('manage-relay/numberrelay', [ManageRelayController::class, 'numberrelay']);
// });

Route::get('manage-status/updatesensor/{voltage}/{current}/{power}/{energy}/{frequency}/{powerfactor}/{mac_address}', [ManageStatusController::class, 'simpansensor']);

Route::get('manage-status/relay/{value}', [ManageStatusController::class, 'relay']);
Route::get('manage-status/send/switch', [ManageStatusController::class, 'send']);
Route::get('manage-status/send/mac-address/{mac_address}', [ManageStatusController::class, 'send_mac_address']);

Route::get('manage-status/get/powerchart', [ManageStatusController::class, 'getPowerChart'])->name('datachart.power');
Route::get('manage-status/get/cardsensor', [ManageStatusController::class, 'getCardSensor'])->name('datacard.all');
// Route::get('manage-relay/relay/{value}', [ManageRelayController::class, 'relay']);
// Route::get('manage-send/', [ManageRelayController::class, 'send']);

// Route::get('manage-status/sensor', [ManageStatusController::class, 'sensor']);

Route::controller(ManageScheduleController::class)->group(function () {
    Route::get('ubahstatus', 'ubahstatus')->name('ubahstatus');
    // Route::get('kirimstatus', 'kirimstatus');
    Route::get('jam', 'jam');
});

Route::controller(SessionController::class)->group(function () {
    Route::get('sesi', 'index')->middleware('isTamu');
    Route::post('/sesi/login', 'login')->middleware('isTamu');
    Route::get('/sesi/logout', 'logout');
    Route::get('sesi/register', 'register')->middleware('isTamu');
    Route::post('/sesi/create', 'create')->middleware('isTamu');
});
