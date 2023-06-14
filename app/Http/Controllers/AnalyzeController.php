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
use Illuminate\Support\Facades\Cache;

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
        $nextMonth = $this->forecast();
        $formattedNextMonth = number_format((float)$nextMonth, 2);
        $this_month = number_format($this->getTotalKwhThisMonth(), 2);

        // $estimated = number_format(max(abs($this->forecast() - $this->getTotalKwhBeforeLastMonth()), 0), 2);

        return view('analyze.index', [
            'title' => 'Analyze'
        ], compact('data'))
            ->with('next_month', $formattedNextMonth)
            ->with('this_month', $this_month);
        // ->with('estimated', $estimated);
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

    public function forecast()
    {
        $user_id = Auth::id();

        $electricityData = Cache::remember('electricity_data_' . $user_id, Carbon::now()->addHours(1), function () use ($user_id) {
            $kwhPerUser = DB::table('tb_device')
                ->join('tb_sensor', 'tb_device.mac_address', '=', 'tb_sensor.mac_address')
                ->where('tb_device.user_id', $user_id)
                ->groupBy('tb_device.user_id', DB::raw('YEAR(tb_sensor.created_at)'), DB::raw('MONTH(tb_sensor.created_at)'))
                ->select(
                    'tb_device.user_id',
                    DB::raw('YEAR(tb_sensor.created_at) as year'),
                    DB::raw('MONTH(tb_sensor.created_at) as month'),
                    DB::raw('SUM(tb_sensor.kwh) as total_kwh')
                )
                ->get();

            $electricityData = [];

            foreach ($kwhPerUser as $reading) {
                $kwh = $reading->total_kwh * (1 / 2582);
                $electricityData[] = $kwh * 1352;
            }

            return $electricityData;
        });

        // Menghitung jumlah data
        $dataCount = count($electricityData);

        // Membuat array untuk menyimpan data independen (bulan ke-) dan dependen (biaya listrik)
        $x = range(1, $dataCount);
        $y = $electricityData;

        // Menghitung persamaan regresi linier menggunakan metode kuadrat terkecil
        $xMean = array_sum($x) / $dataCount;
        $yMean = array_sum($y) / $dataCount;

        $numerator = 0;
        $denominator = 0;

        for ($i = 0; $i < $dataCount; $i++) {
            $numerator += ($x[$i] - $xMean) * ($y[$i] - $yMean);
            $denominator += pow(($x[$i] - $xMean), 2);
        }

        $slope = $numerator / $denominator;
        $intercept = $yMean - ($slope * $xMean);

        // Prediksi biaya listrik bulan berikutnya
        $nextMonth = $dataCount + 1;
        $prediction = $slope * $nextMonth + $intercept;

        // Menampilkan prediksi biaya listrik bulan berikutnya
        return $prediction;
    }

    public function getTotalKwhThisMonth()
    {
        $user_id = Auth::id();

        $electricityData = Cache::remember('total_kwh_this_month_' . $user_id, Carbon::now()->addHours(1), function () use ($user_id) {
            $lastMonthData = DB::table('tb_device')
                ->join('tb_sensor', 'tb_device.mac_address', '=', 'tb_sensor.mac_address')
                ->where('tb_device.user_id', $user_id)
                ->orderByDesc('tb_sensor.created_at')
                ->select('tb_sensor.created_at')
                ->first();

            if ($lastMonthData) {
                $created_at = Carbon::parse($lastMonthData->created_at);
                $startOfMonth = $created_at->startOfMonth();

                $kwhPerUser = DB::table('tb_device')
                    ->join('tb_sensor', 'tb_device.mac_address', '=', 'tb_sensor.mac_address')
                    ->where('tb_device.user_id', $user_id)
                    ->whereMonth('tb_sensor.created_at', $startOfMonth->month)
                    ->whereYear('tb_sensor.created_at', $startOfMonth->year)
                    ->select(DB::raw('SUM(tb_sensor.kwh) as total_kwh'))
                    ->first();

                if ($kwhPerUser) {
                    $kwh = $kwhPerUser->total_kwh * (1 / 2582);
                    $electricityData = $kwh * 1352;
                } else {
                    $electricityData = 0; // Jika tidak ada data, set nilai menjadi 0
                }
            } else {
                $electricityData = 0; // Jika tidak ada data bulan terakhir, set nilai menjadi 0
            }

            return $electricityData;
        });

        return $electricityData;
    }

    public function getTotalKwhBeforeLastMonth()
    {
        $user_id = Auth::id();
        $startOfMonth = now()->startOfMonth();
        $startOfLastMonth = $startOfMonth->subMonth();

        $electricityData = Cache::remember('total_kwh_before_last_month_' . $user_id, Carbon::now()->addHours(1), function () use ($user_id, $startOfLastMonth) {
            $kwhPerUser = DB::table('tb_device')
                ->join('tb_sensor', 'tb_device.mac_address', '=', 'tb_sensor.mac_address')
                ->where('tb_device.user_id', $user_id)
                ->whereMonth('tb_sensor.created_at', $startOfLastMonth->month)
                ->whereYear('tb_sensor.created_at', $startOfLastMonth->year)
                ->select(DB::raw('SUM(tb_sensor.kwh) as total_kwh'))
                ->first();

            if ($kwhPerUser) {
                $kwh = $kwhPerUser->total_kwh * (1 / 2582);
                $electricityData = $kwh * 1352;
            } else {
                $electricityData = 0; // Jika tidak ada data, set nilai menjadi 0
            }

            return $electricityData;
        });

        return $electricityData;
    }

    public function getTotalKwhPerMonth()
    {
        $user_id = Auth::id();

        $electricityData = Cache::remember('total_kwh_per_month_' . $user_id, Carbon::now()->addHours(1), function () use ($user_id) {
            $deviceData = DB::table('tb_device')
                ->where('user_id', $user_id)
                ->pluck('device_name', 'mac_address')
                ->toArray();

            $mac_addresses = array_keys($deviceData);

            $lastMonth = DB::table('tb_sensor')
                ->whereIn('mac_address', $mac_addresses)
                ->max('created_at');

            $kwhPerMonth = DB::table('tb_sensor')
                ->whereIn('mac_address', $mac_addresses)
                ->whereMonth('created_at', date('m', strtotime($lastMonth)))
                ->groupBy('mac_address')
                ->select('mac_address', DB::raw('SUM(kwh) as total_kwh'))
                ->get();

            $electricityData = [];

            foreach ($kwhPerMonth as $reading) {
                $mac_address = $reading->mac_address;
                $device_name = $deviceData[$mac_address];
                $kwh = $reading->total_kwh * (1 / 2582);
                $formatted_kwh = number_format($kwh, 2, '.', '');

                $electricityData[] = [
                    'mac_address' => $mac_address,
                    'device_name' => $device_name,
                    'total_kwh_perdevice' => $formatted_kwh,
                ];
            }

            return $electricityData;
        });

        return response()->json($electricityData);
    }


    public function getTotalKwh()
    {
        $user_id = Auth::id();

        $electricityData = Cache::remember('total_kwh_' . $user_id, Carbon::now()->addHours(1), function () use ($user_id) {
            $kwh = DB::table('tb_sensor')
                ->join('tb_device', 'tb_sensor.mac_address', '=', 'tb_device.mac_address')
                ->where('tb_device.user_id', $user_id)
                ->orderBy('tb_sensor.created_at', 'desc')
                ->selectRaw('MONTH(tb_sensor.created_at) AS month, SUM(tb_sensor.kwh) AS total_kwh')
                ->groupBy('month')
                ->get();

            $conversionFactor = 1 / 2582;
            $cost = 1352; // Faktor konversi dari kWs ke kWh

            $monthlyTotalkwh = [];
            $monthlyCreatedAt = [];

            foreach ($kwh as $data) {
                $month = Carbon::create(null, $data->month)->formatLocalized('%B');

                $kwhValue = $data->total_kwh * $conversionFactor;
                $costValue = $cost * $kwhValue;

                $monthlyTotalkwh[] = $costValue;
                $monthlyCreatedAt[] = $month;
            }

            return response()->json([
                'total_kwh' => $monthlyTotalkwh,
                'created_at' => $monthlyCreatedAt
            ]);
        });

        return $electricityData;
    }

    public function getPowerChart()
    {
        $user_id = Auth::id();

        $electricityData = Cache::remember('power_chart_' . $user_id, Carbon::now()->addHours(1), function () use ($user_id) {
            $latestSensorData = DB::table('tb_sensor')
                ->whereIn('mac_address', function ($query) use ($user_id) {
                    $query->select('mac_address')
                        ->from('tb_device')
                        ->where('user_id', $user_id);
                })
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();

            return response()->json($latestSensorData);
        });

        return $electricityData;
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
