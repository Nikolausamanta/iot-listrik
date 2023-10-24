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

//~ Mac Address
Route::get('manage-device/show-mac', [ManageDeviceController::class, 'getData']);
Route::get('add-device', [ManageStatusModel::class, 'index']);
Route::get('show-mac', [ManageStatusModel::class, 'getData']);


//! Middleware isLogin
Route::middleware('isLogin')->group(function () {

    //~ Tampil SSC
    Route::get('manage-status/{device_id}', [ManageStatusController::class, 'tampil'])->name('manage-status.tampil');
    Route::get('manage-schedule/{device_id}', [ManageScheduleController::class, 'tampil'])->name('manage-schedule.tampil');
    Route::get('manage-countdown/{device_id}', [TimerController::class, 'tampil'])->name('manage-countdown.tampil');

    //~ Resource
    Route::resource('/', DashboardController::class);
    Route::resource('room', RoomController::class);
    Route::resource('alldevice', AllDeviceController::class);
    Route::resource('analyze', AnalyzeController::class);
    Route::resource('manage-schedule', ManageScheduleController::class);
    Route::resource('manage-status', ManageStatusController::class);
    Route::resource('manage-relay', ManageRelayController::class);
    Route::resource('manage-countdown', TimerController::class);
    Route::resource('manage-device', ManageDeviceController::class);
    Route::delete('/manage-device/{device_id}', [DeviceController::class, 'deleteDevice'])->name('manage-device.delete');

    //~ Chart
    Route::get('analyze/get/allpowerchart', [AnalyzeController::class, 'getPowerChart']);
    Route::get('analyze/get/kwh', [AnalyzeController::class, 'getTotalKwh']);
    Route::get('analyze/get/kwhmonth', [AnalyzeController::class, 'getTotalKwhPerMonth']);
    // Route::get('/analyze/get/available-years', [AnalyzeController::class, 'getAvailableYears']);
    Route::get('/analyze/get/forecast', [AnalyzeController::class, 'forecast']);
    Route::get('manage-status/get/powerchart', [ManageStatusController::class, 'getPowerChart'])->name('datachart.power');
    Route::get('manage-status/get/cardsensor', [ManageStatusController::class, 'getCardSensor'])->name('datacard.all');
    Route::get('manage-status/get/totalkwh', [ManageStatusController::class, 'getTotalKwhPerMonth'])->name('datacard.totalkwh');
    // Route::get('analyze/get/allpowercard', [AnalyzeController::class, 'getPowerChart']);

    //~ Tampil Analyze
    Route::get('analyze/{device_id}', [AnalyzeController::class, 'tampil']);

    //~ Timers
    Route::get('/timers/{device_id}', [TimerController::class, 'tampil'])->name('timers.tampil');
    Route::post('/timers', [TimerController::class, 'store'])->name('timers.store');
    Route::post('/timers/{timer}/start', [TimerController::class, 'start'])->name('timers.start');
    Route::post('/timers/{timer}/cancel', [TimerController::class, 'cancel'])->name('timers.cancel');
    Route::post('/timers/{timer}/update-switch', [TimerController::class, 'updateSwitch'])->name('timers.updateSwitch');

    //~ Schedule
    Route::controller(ManageScheduleController::class)->group(function () {
        Route::get('ubahstatus', 'ubahstatus')->name('ubahstatus');
        Route::get('jam', 'jam');
    });
});

//! Middleware isTamu
Route::controller(SessionController::class)->group(function () {
    Route::get('sesi', 'index')->middleware('isTamu');
    Route::post('/sesi/login', 'login')->middleware('isTamu');
    Route::get('/sesi/logout', 'logout');
    Route::get('sesi/register', 'register')->middleware('isTamu');
    Route::post('/sesi/create', 'create')->middleware('isTamu');
});


//~ route permintaan dari nodemcu untuk dapat data schedule dan timer
Route::get('manage-status/send-schedule/{mac_address}', [ManageStatusController::class, 'send_schedule_data']);
//route permintaan dari nodemcu untuk dapat data timer
Route::get('manage-status/send-timer/{mac_address}', [ManageStatusController::class, 'send_timer_data']);

//~ Alat
Route::get('manage-status/updatesensor/{voltage}/{current}/{power}/{energy}/{frequency}/{powerfactor}/{mac_address}', [ManageStatusController::class, 'simpansensor']);
Route::get('manage-status/relay/{value}', [ManageStatusController::class, 'relay']);
Route::get('manage-status/send/switch', [ManageStatusController::class, 'send']);
Route::get('manage-status/send/mac-address/{mac_address}', [ManageStatusController::class, 'send_mac_address']);
