<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\ManageStatusModel;
use App\Models\ManageScheduleModel;
use App\Models\ManageRelayModel;

use Illuminate\Support\Facades\Session;

class ManageScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data1 = ManageScheduleModel::orderBy('updated_at', 'asc')->limit(1)->get();
        // dd($data1);
        $data = ManageScheduleModel::orderBy('updated_at', 'asc')->paginate(6);
        return view('manage.schedule.4-channel.index-schedule', [
            'title' => 'Manage Device'
        ])->with('data_manage_schedule', $data)->with('upcoming', $data1);
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
        Session::flash('nama_schedule', $request->nama_schedule);
        Session::flash('waktu1', $request->waktu1);
        Session::flash('waktu2', $request->waktu2);
        Session::flash('tanggal1', $request->tanggal1);

        $request->validate([
            'nama_schedule' => 'required',
            'waktu1' => 'required',
            'waktu2' => 'required',
            'tanggal1' => 'required',
        ], [
            'nama_schedule.required' => 'diisi woy',
            'waktu1.required' => 'diisi woy',
            'waktu2.required' => 'diisi woy',
            'tanggal1.required' => 'diisi woy',
        ]);

        // $data = [
        //     'nama_schedule' => $request->nama_schedule,
        //     'waktu1' => $request->waktu1,
        //     'waktu2' => $request->waktu2,
        //     'tanggal1' => $request->tanggal1,
        // ];

        // ManageScheduleModel::create($data);

        $nama_schedule = $request->input('nama_schedule');
        $tanggal1 = $request->input('tanggal1');
        $waktu1 = $request->input('waktu1');
        $waktu2 = $request->input('waktu2');

        $gabung1 = $tanggal1 . ' ' . $waktu1;
        $gabung2 = $tanggal1 . ' ' . $waktu2;
        $dateTime1 = Carbon::createFromFormat('Y-m-d H:i:s', $gabung1, 'Asia/Singapore');
        $dateTime2 = Carbon::createFromFormat('Y-m-d H:i:s', $gabung2, 'Asia/Singapore');
        $dateTime1->setTimezone('UTC');
        $dateTime2->setTimezone('UTC');
        $waktuEpoch1 = $dateTime1->timestamp;
        $waktuEpoch2 = $dateTime2->timestamp;

        ManageScheduleModel::create([
            'nama_schedule' => $nama_schedule,
            'waktu1' => $waktuEpoch1,
            'waktu2' => $waktuEpoch2,
        ]);

        return redirect()->to('manage-schedule')->with('success', 'berhasil menambahkan data uy');
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
        // return 'hi' . $id;
        $data = ManageScheduleModel::orderBy('updated_at', 'desc')->paginate(10);
        $data1 = ManageScheduleModel::where('schedule_id', $id)->first();
        $data2 = ManageScheduleModel::orderBy('updated_at', 'desc')->limit(1)->get();
        return view('manage.schedule.4-channel.index-schedule', [
            'title' => 'Manage Device'
        ])
            ->with('data_manage_schedule', $data)
            ->with('edit_schedule', $data1)
            ->with('upcoming', $data2);

        // return view('manage.schedule.4-channel.edit')->with('edit_schedule', $data1);



        // $data2 = ManageScheduleModel::orderBy('updated_at', 'desc')->paginate(5);
        // return view('manage.schedule.4-channel.edit', [
        //     'title' => 'Manage Schedule'
        // ])->with('edit_schedule', $data)->with('data_manage_schedule', $data2);
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
            'nama_schedule' => 'required',
            'waktu1' => 'required',
            'waktu2' => 'required',
            'tanggal1' => 'required',
        ], [
            'nama_schedule.required' => 'diisi woy',
            'waktu.required1' => 'diisi woy',
            'waktu.required2' => 'diisi woy',
            'tanggal.required1' => 'diisi woy',
        ]);

        $data = [
            'nama_schedule' => $request->nama_schedule,
            'waktu1' => $request->waktu1,
            'waktu2' => $request->waktu2,
            'tanggal1' => $request->tanggal1,
        ];

        ManageScheduleModel::where('schedule_id', $id)->update($data);
        return redirect()->to('manage-schedule')->with('success', 'Berhasil melakukan update data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ManageScheduleModel::where('schedule_id', $id)->delete();
        return redirect()->to('manage-schedule')->with('success', 'Berhasil melakukan delete data');
    }

    public function jam()
    {
        date_default_timezone_set('Asia/Singapore');
        // $time = date('H:i:s', time());
        // echo $time;
        $epoch = time();
        echo $epoch;
    }

    public function ubahstatus()
    {
        date_default_timezone_set('Asia/Singapore');
        $time = time();

        $data = ManageScheduleModel::orderBy('schedule_id', 'asc')->get();

        $hasil1 = null;

        foreach ($data as $schedule) {
            $id = $schedule->schedule_id;
            $jam = $schedule->waktu1;
            $jam2 = $schedule->waktu2;

            if ($time == $jam) {
                ManageScheduleModel::where('schedule_id', $id)->update(['status' => 1]);
                $hasil1 = 'hidup';
            } elseif ($time == $jam2) {
                ManageScheduleModel::where('schedule_id', $id)->update(['status' => 0]);
                $hasil1 = 'mati';
                // break; // Keluar dari foreach jika kondisi terpenuhi
            }
        }

        echo $hasil1;
    }

    // public function kirimstatus()
    // {
    //     // $data = ManageScheduleModel::orderBy('schedule_id', 'asc')->get();
    //     // return $data;
    //     $kirimstatus = ManageScheduleModel::where('status')->get();
    //     // $kirimstatus2 = ManageScheduleModel::where('status', '0')->get();

    //     foreach ($kirimstatus as $schedule) {

    //         $id = $schedule->schedule_id;
    //         $status1 = $schedule->status;
    //         $status2 = 1;
    //         $status3 = 0;
    //         // echo $status;

    //         if ($status1 == $status2) {
    //             $check = ManageScheduleModel::where('schedule_id', $id)->get(['status' => 1]);
    //             if ($check == 1) {
    //                 echo "Hidup";
    //             }
    //         }
    //         // elseif ($status == $status2) {
    //         //     echo "Mati";
    //         // }
    //     }
    // }
}
