<?php

namespace App\Http\Controllers;

use App\Models\ManageDeviceModel;
use Illuminate\Http\Request;
use App\Models\ManageStatusModel;
use App\Models\ManageRelayModel;


class ManageStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {

    //     $data = ManageStatusModel::select('*')->get();
    //     $data2 = ManageRelayModel::select('*')->get();
    //     return view('manage.status.4-channel.index-status', [
    //         'title' => 'Status'
    //     ])->with('data', $data2)->with('sensor', $data);
    // }


    public function tampil(Request $request)
    {
        $device_id = $request->route('device_id');
        $device = ManageDeviceModel::where('device_id', $device_id)->first();

        if ($device) {
            $mac_address = $device->mac_address;

            $data1 = ManageStatusModel::where('mac_address', $mac_address)->latest('updated_at')->take(1)->get();
        }


        // // $data1 = ManageStatusModel::where('device_id', $device_id)->get();
        $data2 = ManageRelayModel::where('device_id', $device_id)->get();

        session(['device_id' => $device_id]);


        return view('manage.status.4-channel.index-status', [
            'title' => 'Status'
        ])
            ->with('sensor', $data1)
            ->with('data', $data2)
            ->with('device_id', $device_id);
    }

    public function relay($value)
    {
        $session_device_id = session('device_id');
        $device = ManageDeviceModel::where('device_id', $session_device_id)->first();

        if ($device) {
            $mac_address = $device->mac_address;

            $relay = ManageRelayModel::whereHas('device', function ($query) use ($mac_address) {
                $query->where('mac_address', $mac_address);
            })->first();

            if ($relay) {
                $device_id = $relay->device_id;
                if ($value == "on") {
                    ManageRelayModel::where('device_id', $device_id)->update(['switch' => 1]);
                } else {
                    ManageRelayModel::where('device_id', $device_id)->update(['switch' => 0]);
                }
            }
        }
    }

    public function send()
    {
        $relay_id = 1;
        $dddd = ManageRelayModel::where('relay_id', $relay_id)->pluck('switch');
        return $dddd[0];
    }

    public function send_mac_address(Request $request)
    {
        $mac_address = $request->route('mac_address');
        $aaa = ManageDeviceModel::join('tb_relay', 'tb_device.device_id', '=', 'tb_relay.device_id')
            ->where('tb_device.mac_address', $mac_address)
            ->distinct()
            ->pluck('switch')
            ->implode(', ');
        // $bbb = join($aaa);
        return $aaa;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function simpansensor(Request $request)
    {
        $voltage = $request->route('voltage');
        $current = $request->route('current');
        $power = $request->route('power');
        $energy = $request->route('energy');
        $frequency = $request->route('frequency');
        $powerfactor = $request->route('powerfactor');
        $mac_address = $request->route('mac_address');

        ManageStatusModel::create([
            'voltage' => $voltage,
            'current' => $current,
            'power' => $power,
            'energy' => $energy,
            'frequency' => $frequency,
            'powerfactor' => $powerfactor,
            'mac_address' => $mac_address,
        ]);

        // $data = [
        //     'voltage' => request()->voltage,
        //     'current' => request()->current,
        //     'power' => request()->power,
        //     'energy' => request()->energy,
        //     'frequency' => request()->frequency,
        //     'powerfactor' => request()->powerfactor,
        // ];

        // ManageStatusModel::where('sensor_id', '1')->update($data);
        // ManageScheduleModel::where('schedule_id', $id)->update($data);
        // $sensor = ManageStatusModel::select('*')->get();
        // return view('manage.status.4-channel.index-status')->with('sensor', $sensor);
    }

    public function sensor()
    {
        $sensor = ManageStatusModel::select('*')->get();
        return view('manage.status.4-channel.index-status', [
            'title' => 'Status'
        ])->with('sensor', $sensor);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
