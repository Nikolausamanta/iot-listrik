<?php

namespace App\Http\Controllers;

use App\Models\TimerModel;
use Illuminate\Support\Facades\Validator;
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
        $validationRules = [
            'device_name' => 'required',
            'mac_address' => [
                'required',
                'min:12',
                function ($attribute, $value, $fail) {
                    $existingData = ManageDeviceModel::where('mac_address', $value)->first();

                    if ($existingData) {
                        $fail('The mac address has already been added.');
                    }
                },
            ],
        ];

        $request->validate($validationRules, [
            'device_name.required' => 'The device name field is required.',
            'mac_address.required' => 'The mac address field is required.',
            'mac_address.min' => 'The mac address must be 12 digits.',
        ]);

        $userID = Auth::id();

        $data = [
            'device_name' => $request->device_name,
            'mac_address' => $request->mac_address,
            'user_id' => $userID
        ];

        $deviceId = ManageDeviceModel::insertGetId($data, 'deviceId');

        // Check if the device_id has multiple mac_address
        $existingMacAddresses = ManageDeviceModel::where('mac_address', $request->mac_address)
            ->where('device_id', '<>', $deviceId)
            ->pluck('mac_address')
            ->toArray();

        if (count($existingMacAddresses) == 0) {
            $dataRelay = [
                'device_id' => $deviceId,
            ];

            ManageRelayModel::firstOrCreate($dataRelay);

            // $dataSensor = [
            //     'device_id' => $deviceId,
            // ];

            // ManageStatusModel::firstOrCreate($dataSensor);
        }

        return redirect()->to('/alldevice')->with('success', 'Successfully added the device!');
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
        $session_device_id = session('device_id');

        $data = ManageDeviceModel::where('device_id', $id)->first();

        return view('manage.device.alldevice.edit', [
            'title' => 'Manage Device'
        ])->with('edit_device', $data);
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
        $request->validate([
            'device_name' => 'required',
            'mac_address' => [
                'required',
                'min:12',
                function ($attribute, $value, $fail) use ($id) {
                    $existingData = ManageDeviceModel::where('mac_address', $value)
                        ->where('device_id', '<>', $id)
                        ->first();

                    if ($existingData) {
                        $fail('The mac address has already been added.');
                    }
                },
            ],
        ], [
            'device_name.required' => 'The device name field is required.',
            'mac_address.required' => 'The mac address field is required.',
            'mac_address.min' => 'The mac address must be 12 digits.',
        ]);

        $data = [
            'device_name' => $request->device_name,
            'mac_address' => $request->mac_address,
            'user_id' => Auth::id()
        ];

        ManageDeviceModel::where('device_id', $id)->update($data);

        return redirect()->to('/alldevice')->with('success', 'Successfully updated the device!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Menghapus ManageStatusModel terkait
        $device = ManageDeviceModel::where('device_id', $id)->first();
        if ($device) {
            $mac_address = $device->mac_address;

            ManageStatusModel::where('mac_address', $mac_address)->delete();
        }

        // Menghapus relasi ManageRelayModel terkait
        ManageDeviceModel::find($id)->relays()->delete();

        // Menghapus relasi TimerModel terkait
        ManageDeviceModel::find($id)->timers()->delete();

        // Menghapus relasi ManageScheduleModel terkait
        ManageDeviceModel::find($id)->schedules()->delete();

        // Menghapus data dari ManageDeviceModel
        ManageDeviceModel::where('device_id', $id)->delete();

        return redirect()->back()->with('success', 'Device has been successfully deleted!');
    }
}
