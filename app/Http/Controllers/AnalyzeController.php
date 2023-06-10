<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllDeviceModel;
use App\Models\ManageRelayModel;
use App\Models\ManageDeviceModel;
use App\Models\ManageStatusModel;
use Illuminate\Support\Facades\Auth;

class AnalyzeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $data = AllDeviceModel::where('user_id', $userId)->get();
        return view('analyze.index', [
            'title' => 'Analyze'
        ], compact('data'));
    }

    public function tampil(Request $request)
    {
        $device_id = $request->route('device_id');
        $device_name = ManageDeviceModel::where('device_id', $device_id)->value('device_name');
        $device = ManageDeviceModel::where('device_id', $device_id)->get();

        // if ($device) {
        //     $mac_address = $device->mac_address;

        //     $data1 = ManageStatusModel::where('mac_address', $mac_address)->latest('updated_at')->take(1)->get();
        // }



        session(['device_id' => $device_id]);

        return view('analyze.index', [
            'title' => 'Status'
        ])
            ->with('device_id', $device_id)
            ->with('device_name', $device_name)
            ->with('device', $device);
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
