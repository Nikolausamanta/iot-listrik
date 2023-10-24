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

        $this_month = number_format($this->getTotalKwhThisMonth(), 2);
        $next_month = number_format($this->getTotalKwhNextMonth(), 2);
        $prediction_this_month = number_format($this->getPredictionTotalKwhThisMonth(), 2);


        // Mengambil total kwh sebelum bulan ini
        $totalKwhBeforeThisMonth = $this->getTotalKwhBeforeThisMonth();

        // Mengambil prediksi total kwh bulan ini
        $predictionTotalKwhThisMonth = $this->getPredictionTotalKwhThisMonth();

        // Menghitung selisih antara total kwh sebelum bulan ini dan prediksi total kwh bulan ini
        $difference = $totalKwhBeforeThisMonth - $predictionTotalKwhThisMonth;

        // Menetapkan nilai selisih menjadi nol jika hasilnya negatif
        $difference = $difference < 0 ? 0 : $difference;
        $estimated_savings = number_format($difference, 2);

        return view('analyze.index', [
            'title' => 'Analyze'
        ], compact('data'))
            ->with('next_month', $next_month)
            ->with('this_month', $this_month)
            ->with('before_this_month', $estimated_savings)
            ->with('prediction_this_month', $prediction_this_month);
        // ->with('estimated', $estimated);
    }

    // public function tampil(Request $request)
    // {
    //     $device_id = $request->route('device_id');
    //     $device_name = ManageDeviceModel::where('device_id', $device_id)->value('device_name');
    //     $device = ManageDeviceModel::where('device_id', $device_id)->get();

    //     session(['device_id' => $device_id]);

    //     return view('analyze.index', [
    //         'title' => 'Status'
    //     ])
    //         ->with('device_id', $device_id)
    //         ->with('device_name', $device_name)
    //         ->with('device', $device);
    // }

    public function forecast()
    {
        $user_id = Auth::id();

        $mac_addresses = DB::table('tb_device')
            ->where('user_id', $user_id)
            ->pluck('mac_address')
            ->toArray();

        // Ambil data historis biaya listrik dari database
        $readings = ManageStatusModel::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(kwh) as total_kwh')
            ->whereIn('mac_address', $mac_addresses)
            ->groupBy('year', 'month')
            ->get();

        $electricityData = [];

        foreach ($readings as $reading) {
            $kwh = $reading->total_kwh * (1 / 2582);
            $electricityData[] = round($kwh * 1352);
        }

        // Menghitung jumlah data
        $dataCount = count($electricityData);

        $x = [];
        $y = [];
        $xy = [];
        $xx = [];

        // Membuat array untuk menyimpan data independen X (bulan ke-) dan dependen Y (biaya listrik)
        for ($i = 0; $i < $dataCount; $i++) {
            $x[$i] = $i + 1;
            $y[$i] = $electricityData[$i];
            $xy[$i] = $x[$i] * $y[$i];
            $xx[$i] = $x[$i] * $x[$i];
        }

        // Menghitung nilai-nilai sigma
        $sigma_x = array_sum($x);
        $sigma_y = array_sum($y);
        $sigma_xy = array_sum($xy);
        $sigma_xx = array_sum($xx);

        // Menghitung a dan b
        $numerator = ($dataCount * $sigma_xy) - ($sigma_x * $sigma_y); //Pembilang
        $denominator = ($dataCount * $sigma_xx) - ($sigma_x * $sigma_x); //Pembagi

        $b = $numerator / $denominator;
        $a = ($sigma_y - ($b * $sigma_x)) / $dataCount;

        // Prediksi biaya listrik bulan berikutnya
        $nextMonth = $dataCount + 1;
        $prediction = round($b * $nextMonth + $a);

        // Menyiapkan data aktual dan prediksi setiap bulan
        $monthlyData = [];
        for ($i = 0; $i < $dataCount; $i++) {
            $monthName = Carbon::createFromFormat('!m', $i + 1)->monthName;
            $monthlyData[] = [
                'year' => $readings[$i]->year,
                'month' => $monthName,
                'actual' => $y[$i],
                'predicted' => round($b * ($i + 1) + $a), // Bulatkan nilai prediksi menjadi bilangan bulat
            ];
        }

        // Menambahkan data prediksi untuk bulan berikutnya
        $nextMonthName = Carbon::createFromFormat('!m', $nextMonth)->monthName;
        $monthlyData[] = [
            'year' => $readings[$dataCount - 1]->year,
            'month' => $nextMonthName,
            'actual' => null,
            'predicted' => $prediction,
        ];

        return response()->json($monthlyData);
    }

    public function getTotalKwhNextMonth()
    {
        // Mengambil data historis biaya listrik dari database
        $readings = ManageStatusModel::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(kwh) as total_kwh')
            ->groupBy('year', 'month')
            ->get();

        $electricityData = [];

        foreach ($readings as $reading) {
            $kwh = $reading->total_kwh * (1 / 2582);
            $electricityData[] = $kwh * 1352;
        }

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

        $slope = $numerator / $denominator; // hitung gradien garis regresi
        $intercept = $yMean - ($slope * $xMean);  // titik potong garis regresi dengan sumbu y

        // Prediksi biaya listrik bulan berikutnya
        $nextMonth = $dataCount + 1;
        $prediction = $slope * $nextMonth + $intercept;

        // Menampilkan prediksi biaya listrik bulan berikutnya
        return $prediction;
    }

    public function getTotalKwhBeforeThisMonth()
    {
        // Mengambil data historis biaya listrik dari database
        $currentMonth = date('n'); // Mendapatkan bulan saat ini (1-12)
        $currentYear = date('Y'); // Mendapatkan tahun saat ini (4 digit)
        $previousMonth = $currentMonth - 1;

        // Jika bulan saat ini adalah Januari, maka bulan sebelumnya adalah Desember tahun sebelumnya
        if ($previousMonth == 0) {
            $previousMonth = 12;
            $currentYear -= 1;
        }

        $previousMonthData = ManageStatusModel::selectRaw('SUM(kwh) as total_kwh')
            ->whereMonth('created_at', $previousMonth)
            ->whereYear('created_at', $currentYear)
            ->first();

        if ($previousMonthData) {
            $kwh = $previousMonthData->total_kwh * (1 / 2582);
            $electricityData = $kwh * 1352;
        } else {
            $electricityData = 0;
        }

        // Menampilkan data aktual biaya listrik bulan sebelumnya
        return $electricityData;
    }


    public function getTotalKwhThisMonth()
    {
        // Mengambil data historis biaya listrik dari database
        $currentMonth = date('n'); // Mendapatkan bulan saat ini (1-12)
        $currentYear = date('Y'); // Mendapatkan tahun saat ini (4 digit)

        $currentMonthData = ManageStatusModel::selectRaw('SUM(kwh) as total_kwh')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->first();

        if ($currentMonthData) {
            $kwh = $currentMonthData->total_kwh * (1 / 2582);
            $electricityData = $kwh * 1352;
        } else {
            $electricityData = 0;
        }

        // Menampilkan data aktual biaya listrik bulan ini
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

    public function getPredictionTotalKwhThisMonth()
    {
        // Mengambil data historis biaya listrik dari database
        $readings = ManageStatusModel::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(kwh) as total_kwh')
            ->groupBy('year', 'month')
            ->get();

        $electricityData = [];

        foreach ($readings as $reading) {
            $kwh = $reading->total_kwh * (1 / 2582);
            $electricityData[] = $kwh * 1352;
        }

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

        // Prediksi biaya listrik bulan ini
        $currentMonth = $dataCount;
        $prediction = $slope * $currentMonth + $intercept;

        // Menampilkan prediksi biaya listrik bulan ini
        return $prediction;
    }


    // Yang PerDevice atau perperangkat
    public function getTotalKwhPerMonth()
    {
        $user_id = Auth::id();

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
