<?php

namespace App\Http\Controllers;

use App\Models\TimerModel;
use Illuminate\Http\Request;
use App\Models\MacAddressModel;
use App\Models\ManageRelayModel;
use App\Models\ManageDeviceModel;
use App\Models\ManageStatusModel;
use App\Models\ManageScheduleModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ManageDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('manage.device', [
        //     'title' => 'Manage Device'
        // ]);
    }
    public function getData()
    {
        $macAddresses = MacAddressModel::orderBy('id', 'desc')->first();

        return response()->json($macAddresses);
    }

    public function sendMacAddress(Request $request)
    {
        $macAddress = new MacAddressModel();
        $macAddress->mac_address = $request->input('mac_address');
        $macAddress->save();

        return response()->json(['message' => 'Mac address Sudah Simpan DB']);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage.device.alldevice.create', [
            'title' => 'Add Device'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Session::flash('device_name', $request->device_name);
        Session::flash('mac_address', $request->mac_address);

        $request->validate([
            'device_name' => 'required',
            'mac_address' => 'required',
        ], [
            'device_name.required' => 'diisi woy',
            'mac_address.required' => 'diisi woy',
        ]);

        $userID = Auth::id();

        $data = [
            'device_name' => $request->device_name,
            'mac_address' => $request->mac_address,
            'user_id' => $userID
        ];

        $deviceId = ManageDeviceModel::insertGetId($data, 'deviceId');
        // $deviceId = $aaa->device_id;

        $dataRelay = [
            'device_id' => $deviceId,
        ];

        $dataSensor = [
            'device_id' => $deviceId,
        ];

        ManageRelayModel::create($dataRelay);
        ManageStatusModel::create($dataSensor);


        return redirect()->to('/alldevice')->with('success', 'berhasil menambahkan device uy');
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
