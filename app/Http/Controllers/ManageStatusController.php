<?php

namespace App\Http\Controllers;

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

        $data1 = ManageStatusModel::where('device_id', $device_id)->get();
        $data2 = ManageRelayModel::where('device_id', $device_id)->get();

        session(['device_id' => $device_id]);

        // return $data2;
        return view('manage.status.4-channel.index-status', [
            'title' => 'Status'
        ])->with('sensor', $data1)->with('data', $data2)->with('device_id', $device_id);
    }

    public function relay($value)
    {
        $device_id_session = session('device_id');
        // $data22 = '2';
        $data = ManageRelayModel::where('device_id', $device_id_session)->get();
        // return $data;
        foreach ($data as $relay) {
            $device_id = $relay->device_id;
            $relay_id = $relay->relay_id;
            $switch = $relay->switch;

            if ($device_id == $device_id_session) {
                if ($value == "on") {
                    ManageRelayModel::where('relay_id', $relay_id)->update(['switch' => 1]);
                    $hasil = 1;
                } else {
                    ManageRelayModel::where('relay_id', $relay_id)->update(['switch' => 0]);
                    $hasil = 0;
                }
            }
        }

        return $hasil;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function simpansensor()
    {

        $data = [
            'voltage' => request()->voltage,
            'current' => request()->current,
            'power' => request()->power,
            'energy' => request()->energy,
            'frequency' => request()->frequency,
            'powerfactor' => request()->powerfactor,
        ];
        ManageStatusModel::where('sensor_id', '1')->update($data);
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
