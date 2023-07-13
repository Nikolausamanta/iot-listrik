<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\TimerModel;
use Illuminate\Http\Request;
use App\Models\ManageRelayModel;
use App\Models\ManageDeviceModel;
use App\Models\ManageStatusModel;
use Illuminate\Support\Facades\DB;
use App\Models\ManageScheduleModel;
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

        $totalKwh = $this->getTotalKwhPerMonth();

        // // $data1 = ManageStatusModel::where('device_id', $device_id)->get();
        $data2 = ManageRelayModel::where('device_id', $device_id)->get();

        session(['device_id' => $device_id]);

        return view('manage.status.4-channel.index-status', [
            'title' => 'Status'
        ])
            ->with('device_name', $device_name)
            ->with('data', $data2)
            ->with('totalKwh', $totalKwh)
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

    // Merubah Value Relay
    public function relay($value)
    {
        $session_device_id = session('device_id');

        if ($value == "on") {
            ManageRelayModel::where('device_id', $session_device_id)->update(['switch' => 1]);
        } else {
            ManageRelayModel::where('device_id', $session_device_id)->update(['switch' => 0]);
        }
    }

    // public function send()
    // {
    //     $relay_id = 1;
    //     $dddd = ManageRelayModel::where('relay_id', $relay_id)->pluck('switch');
    //     return $dddd[0];
    // }

    public function getFormattedTime($time)
    {
        $carbonTime = Carbon::createFromTimestamp($time);
        $formattedTime = $carbonTime->format('D H:i:s');
        $formattedTime = str_replace(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'], $formattedTime);
        return $formattedTime;
    }

    public function send_schedule_data(Request $request)
    {
        $mac_address = $request->route('mac_address');
        $schedules = ManageDeviceModel::join('tb_schedule', 'tb_device.device_id', '=', 'tb_schedule.device_id')
            ->where('tb_device.mac_address', $mac_address)
            ->distinct()
            ->select('schedule_id', 'nama_schedule', 'time', 'status', 'schedule_condition')
            ->orderBy('time', 'asc')
            ->limit(1)
            ->get();


        $Hschedule = [];
        foreach ($schedules as $a) {
            $formattedTime = $this->getFormattedTime($a->time);
            $Cstatus = $a->status == 1 ? 'on' : 'off';
            $Hschedule[] = [
                'schedule_id' => $a->schedule_id,
                'nama_schedule' => $a->nama_schedule,
                'time' => $formattedTime,
                'status' => $Cstatus,
                'schedule_condition' => $a->schedule_condition,
            ];
        }

        return response()->json($Hschedule);
    }

    public function send_timer_data(Request $request)
    {
        $mac_address = $request->route('mac_address');
        $aaa = ManageDeviceModel::join('tb_timer', 'tb_device.device_id', '=', 'tb_timer.device_id')
            ->where('tb_device.mac_address', $mac_address)
            ->distinct()
            ->select('timer_id', 'device_name', 'duration', 'status')
            ->limit(1)
            ->get();
        // ->implode(', ');
        // $bbb = join($aaa);
        $Hstatus = [];
        foreach ($aaa as $a) {
            $Cstatus = $a->status == 1 ? 'on' : 'off';
            $Hstatus[] = [
                'timer_id' => $a->timer_id,
                'device_name' => $a->device_name,
                'duration' => $a->duration,
                'status' => $Cstatus,
            ];
        }
        // return $Hstatus;
        return response()->json($Hstatus);
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

    // Yang PerDevice atau perperangkat
    // public function getTotalKwhPerMonth()
    // {
    //     $session_device_id = session('device_id');
    //     $device = ManageDeviceModel::where('device_id', $session_device_id)->first();

    //     if ($device) {
    //         $mac_address = $device->mac_address;

    //         $lastMonth = DB::table('tb_sensor')
    //             ->where('mac_address', $mac_address)
    //             ->max('created_at');

    //         $kwhPerMonth = DB::table('tb_sensor')
    //             ->where('mac_address', $mac_address)
    //             ->whereMonth('created_at', date('m', strtotime($lastMonth)))
    //             ->groupBy('mac_address')
    //             ->select('mac_address', DB::raw('SUM(kwh) as total_kwh'))
    //             ->first();

    //         $kwh = $kwhPerMonth->total_kwh * (1 / 2582);
    //         $formatted_kwh = number_format($kwh, 2, '.', '');

    //         return $formatted_kwh;
    //     }
    // }

    public function getTotalKwhPerMonth()
    {
        $session_device_id = session('device_id');
        $device = ManageDeviceModel::where('device_id', $session_device_id)->first();

        if ($device) {
            $mac_address = $device->mac_address;

            $lastMonth = DB::table('tb_sensor')
                ->where('mac_address', $mac_address)
                ->max('created_at');

            $kwhPerMonth = DB::table('tb_sensor')
                ->where('mac_address', $mac_address)
                ->whereMonth('created_at', date('m', strtotime($lastMonth)))
                ->groupBy('mac_address')
                ->select('mac_address', DB::raw('SUM(kwh) as total_kwh'))
                ->first();

            // Periksa apakah $kwhPerMonth bernilai null, jika ya, maka set total_kwh menjadi 0
            $total_kwh = $kwhPerMonth ? $kwhPerMonth->total_kwh : 0;

            $kwh = $total_kwh * (1 / 2582);
            $formatted_kwh = number_format($kwh, 2, '.', '');

            return $formatted_kwh;
        }
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
