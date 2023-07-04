<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ManageDeviceModel;
use Illuminate\Support\Facades\DB;
use App\Models\ManageScheduleModel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userID = Auth::id();
        $currentTimestamp = strtotime(gmdate('Y-m-d H:i:s')) + (8 * 3600); // Waktu sekarang dalam UTC+8 (GMT+8)

        $data = DB::table('tb_schedule')
            ->select('nama_schedule', 'time', 'status', 'schedule_condition')
            ->where('time', '>', $currentTimestamp)
            ->join('tb_device', 'tb_schedule.device_id', '=', 'tb_device.device_id')
            ->where('tb_device.user_id', $userID)
            ->orderBy('time', 'asc')
            ->first();

        $query = DB::table('tb_device')
            ->join('tb_relay', 'tb_device.device_id', '=', 'tb_relay.device_id')
            ->leftJoin('tb_schedule', 'tb_device.device_id', '=', 'tb_schedule.device_id')
            ->select(
                'tb_device.device_name',
                'tb_relay.switch',
                DB::raw('IFNULL(COUNT(tb_schedule.schedule_group), 0) AS total_schedule')
            )
            ->where('tb_device.user_id', '=', $userID)
            ->groupBy('tb_device.device_name', 'tb_relay.switch');

        $results = $query->get();

        $totalDevices = DB::table('tb_device')
            ->where('user_id', '=', $userID)
            ->count();

        return view('dashboard.index', [
            'title' => 'Dashboard'
        ])
            ->with('device', $results)
            ->with('upcoming', $data)
            ->with('totalDevices', $totalDevices);
    }


    // public function index()
    // {
    //     return view('dashboard.index', [
    //         'title' => 'Dashboard'
    //     ]);
    // }


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
    public function store(Request $request)
    {
        //
    }

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
