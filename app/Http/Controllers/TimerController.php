<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\TimerModel;
use Illuminate\Http\Request;
use App\Models\ManageRelayModel;
use App\Models\ManageDeviceModel;
use App\Models\ManageScheduleModel;
use Illuminate\Support\Facades\Log;

class TimerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $timers = TimerModel::all();

    //     return view('timer.index', [
    //         'title' => 'Manage Device'
    //     ], compact('timers'));
    // }

    public function tampil(Request $request)
    {
        $device_id = $request->route('device_id');
        $timers = TimerModel::where('device_id', $device_id)->get();
        $device_name = ManageDeviceModel::where('device_id', $device_id)->value('device_name');

        session(['device_id' => $device_id]);

        return view('timer.index', [
            'title' => 'Status'
        ], compact('timers'))->with('device_id', $device_id)->with('device_name', $device_name);
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required',
            'duration_hour' => 'required|integer|min:0',
            'duration_minute' => 'required|integer|min:0',
            'duration_second' => 'required|integer|min:0',
        ], [
            'device_id.required' => 'The Device ID field is required.',
            'duration_hour.required' => 'The Duration (Hour) field is required.',
            'duration_hour.integer' => 'The Duration (Hour) field must be an integer.',
            'duration_hour.min' => 'The Duration (Hour) field must be at least 0.',
            'duration_minute.required' => 'The Duration (Minute) field is required.',
            'duration_minute.integer' => 'The Duration (Minute) field must be an integer.',
            'duration_minute.min' => 'The Duration (Minute) field must be at least 0.',
            'duration_second.required' => 'The Duration (Second) field is required.',
            'duration_second.integer' => 'The Duration (Second) field must be an integer.',
            'duration_second.min' => 'The Duration (Second) field must be at least 0.',
        ]);

        $duration = $request->duration_hour * 3600 + $request->duration_minute * 60 + $request->duration_second;

        TimerModel::createOrUpdate($request->device_id, $duration, $request->status);

        $device_id_session = session('device_id');

        return redirect('/timers/' . $device_id_session)->with('success', 'Timer created or updated successfully.');
    }

    // public function start(Request $request, TimerModel $timer)
    // {
    //     $timer->startTimer();
    //     $device_id_session = session('device_id');

    //     return redirect('/timers/' . $device_id_session)->with('success', 'Timer started successfully.');
    // }

    public function cancel(Request $request, TimerModel $timer)
    {
        $timer->cancelTimer();
        $device_id_session = session('device_id');

        return redirect('/timers/' . $device_id_session)->with('success', 'Timer canceled successfully.');
    }

    public function updateSwitch(Request $request, $timer)
    {
        $session_device_id = session('device_id');
        $data = TimerModel::where('device_id', $session_device_id)->get();

        foreach ($data as $schedule) {
            $device_id = $schedule->device_id;
            $status = $schedule->status;

            if ($device_id == $session_device_id) {
                ManageRelayModel::where('device_id', $session_device_id)->update(['switch' => $status]);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
