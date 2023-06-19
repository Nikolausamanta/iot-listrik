<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ManageRelayModel;
use App\Models\ManageDeviceModel;
use App\Models\ManageStatusModel;
use Symfony\Component\VarDumper\VarDumper;

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
        $device_name = ManageDeviceModel::where('device_id', $device_id)->value('device_name');

        // if ($device) {
        //     $mac_address = $device->mac_address;

        //     $data1 = ManageStatusModel::where('mac_address', $mac_address)->latest('updated_at')->take(1)->get();
        // }


        // // $data1 = ManageStatusModel::where('device_id', $device_id)->get();
        $data2 = ManageRelayModel::where('device_id', $device_id)->get();

        session(['device_id' => $device_id]);

        return view('manage.status.4-channel.index-status', [
            'title' => 'Status'
        ])
            ->with('device_name', $device_name)
            ->with('data', $data2)
            ->with('device_id', $device_id);
    }



    public function getPowerChart()
    {
        $session_device_id = session('device_id');
        $device = ManageDeviceModel::where('device_id', $session_device_id)->first();

        if ($device) {
            $mac_address = $device->mac_address;

            $data = ManageStatusModel::where('mac_address', $mac_address)
                ->latest('updated_at')
                ->take(15)
                ->select('power', 'updated_at')
                ->get()
                ->map(function ($item) {
                    return [
                        'power' => $item->power,
                        'updated_at' => Carbon::parse($item->updated_at)->format('H:i:s')
                    ];
                });

            return response()->json($data);
        }
    }



    public function getCardSensor(Request $request)
    {
        $session_device_id = $request->session()->get('device_id');
        $device = ManageDeviceModel::where('device_id', $session_device_id)->first();

        if ($device) {
            $mac_address = $device->mac_address;

            $data = ManageStatusModel::where('mac_address', $mac_address)
                ->latest('updated_at')
                ->select('voltage', 'current', 'power', 'energy', 'frequency', 'powerfactor')
                ->first();

            // Format decimal fields with a maximum of two decimal places
            $formattedData = [
                'voltage' => number_format($data->voltage, 2, '.', ''),
                'current' => number_format($data->current, 2, '.', ''),
                'power' => number_format($data->power, 2, '.', ''),
                'energy' => number_format($data->energy, 2, '.', ''),
                'frequency' => number_format($data->frequency, 2, '.', ''),
                'powerfactor' => number_format($data->powerfactor, 2, '.', ''),
            ];

            return response()->json($formattedData);
        }
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

        $kw = $power / 500;
        // var_dump($energy);

        // Create a new TbSensor model
        $tbSensor = new ManageStatusModel();
        $tbSensor->mac_address = $mac_address;
        $tbSensor->power = $power;
        $tbSensor->current = $current;
        $tbSensor->energy = $energy;
        $tbSensor->frequency = $frequency;
        $tbSensor->powerfactor = $powerfactor;
        $tbSensor->voltage = $voltage;
        $tbSensor->kwh = $kw;
        // $tbSensor->created_at = now();

        $tbSensor->save();
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
