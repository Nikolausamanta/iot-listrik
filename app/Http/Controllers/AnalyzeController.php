<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AllDeviceModel;
use App\Models\ManageRelayModel;
use App\Models\ManageDeviceModel;
use App\Models\ManageStatusModel;
use Illuminate\Support\Facades\DB;
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

        $powerData = ManageStatusModel::all(); // Ambil semua data power dari model atau sumber data Anda
        $totalKwh = $this->calculateTotalKwh($powerData);

        return view('analyze.index', [
            'title' => 'Analyze'
        ], compact('data'))->with('totalkwh', $totalKwh);
    }

    private function calculateTotalKwh($powerData)
    {
        $totalKwh = 0;
        $previousTime = null;
        $previousPower = null;

        foreach ($powerData as $data) {
            $time = strtotime($data->created_at); // Waktu pencatatan dalam format timestamp
            $power = $data->power; // Daya dalam watt

            if ($previousTime !== null && $previousPower !== null) {
                $durationInHours = ($time - $previousTime) / 3600; // Durasi dalam jam
                $averagePower = ($power + $previousPower) / 2; // Daya rata-rata

                $kWh = ($averagePower * $durationInHours) / 1000; // kWh = (daya rata-rata * durasi) / 1000
                $totalKwh += $kWh;
            }

            $previousTime = $time;
            $previousPower = $power;
        }
        $totalKwh = number_format($totalKwh, 7);
        return $totalKwh;
    }


    public function tampil(Request $request)
    {
        $device_id = $request->route('device_id');
        $device_name = ManageDeviceModel::where('device_id', $device_id)->value('device_name');
        $device = ManageDeviceModel::where('device_id', $device_id)->get();

        session(['device_id' => $device_id]);

        return view('analyze.index', [
            'title' => 'Status'
        ])
            ->with('device_id', $device_id)
            ->with('device_name', $device_name)
            ->with('device', $device);
    }

    public function getTotalKwh()
    {
        $user_id = Auth::id();

        $mac_addresses = DB::table('tb_device')
            ->where('user_id', $user_id)
            ->pluck('mac_address')
            ->toArray();

        $kwh = DB::table('tb_sensor')
            ->whereIn('mac_address', $mac_addresses)
            ->orderBy('created_at', 'desc')
            ->get();

        $kwhSum = 0;
        $conversionFactor = 1 / 2582;
        $cost = 1352; // Faktor konversi dari kWs ke kWh

        $limitedCreatedAt = $kwh->pluck('created_at')->take(6)->toArray();
        $totalkwh = []; // Menyimpan nilai total kwh

        foreach ($kwh as $data) {
            $kwhValue = $data->kwh * $conversionFactor;
            $costValue = $cost * $kwhValue;
            $kwhSum += $costValue;
            $totalkwh[] = $kwhSum; // Menambahkan nilai total kwh ke array
        }

        // Mengambil 6 elemen terbaru dari array $totalkwh
        $limitedTotalkwh = array_slice($totalkwh, -6);

        // Memajukan digit total_kwh dengan mengalikan dengan 10
        $shiftedTotalkwh = array_map(function ($value) {
            return $value * 1;
        }, $limitedTotalkwh);

        return response()->json([
            'total_kwh' => $shiftedTotalkwh,
            'created_at' => $limitedCreatedAt
        ]);
    }


    public function getPowerChart()
    {
        $user_id = Auth::id();

        $mac_addresses = DB::table('tb_device')
            ->where('user_id', $user_id)
            ->pluck('mac_address')
            ->toArray();

        $latestSensorData = DB::table('tb_sensor')
            ->whereIn('mac_address', $mac_addresses)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return response()->json($latestSensorData);
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

            return response()->json($data);
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
