<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\TimerModel;
use Illuminate\Http\Request;
use App\Models\ManageRelayModel;
use Illuminate\Support\Facades\Log;

class TimerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timers = TimerModel::all();

        return view('timer.index', [
            'title' => 'Manage Device'
        ], compact('timers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'relay_id' => 'required',
            'duration_hour' => 'required|integer|min:0',
            'duration_minute' => 'required|integer|min:0',
            'duration_second' => 'required|integer|min:0',
        ]);

        $duration = $request->duration_hour * 3600 + $request->duration_minute * 60 + $request->duration_second;

        TimerModel::createOrUpdate($request->relay_id, $duration);

        return redirect()->route('timers.index')->with('success', 'Timer created or updated successfully.');
    }

    public function start(Request $request, TimerModel $timer)
    {
        $timer->startTimer();

        return redirect()->route('timers.index')->with('success', 'Timer started successfully.');
    }

    public function cancel(Request $request, TimerModel $timer)
    {
        $timer->cancelTimer();

        return redirect()->route('timers.index')->with('success', 'Timer canceled successfully.');
    }

    public function updateSwitch(Request $request, $timer)
    {
        $dataTimer = TimerModel::where('timer_id', $timer)->get('relay_id');

        foreach ($dataTimer as $schedule) {
            $relay_id = $schedule->relay_id;
            $relay = ManageRelayModel::where('relay_id', $relay_id)->first();

            // Memperbarui nilai switch berdasarkan kondisi yang diberikan
            $newSwitchValue = ($relay->switch == 0) ? 1 : 0;

            ManageRelayModel::where('relay_id', $relay_id)->update(['switch' => $newSwitchValue]);
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
