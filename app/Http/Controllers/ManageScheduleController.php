<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\ManageRelayModel;
use App\Models\ManageDeviceModel;
use App\Models\ManageStatusModel;

use Illuminate\Support\Facades\DB;
use App\Models\ManageScheduleModel;
use Illuminate\Support\Facades\Session;

class ManageScheduleController extends Controller
{

    public function tampil(Request $request)
    {
        $device_id = $request->route('device_id');
        $device_name = ManageDeviceModel::where('device_id', $device_id)->value('device_name');

        $schedules = ManageScheduleModel::where('device_id', $device_id)->select('schedule_group', 'nama_schedule', 'status', 'time', 'schedule_condition')
            ->groupBy('schedule_group', 'nama_schedule', 'status', 'time', 'schedule_condition')
            ->get();

        $groupedSchedules = [];

        foreach ($schedules as $schedule) {
            $formattedTime = $this->getFormattedTime($schedule->time);
            $groupedSchedules[$schedule->schedule_group][] = [
                'nama_schedule' => $schedule->nama_schedule,
                'time' => $formattedTime,
                'status' => $schedule->status,
                'schedule_condition' => $schedule->schedule_condition,
            ];
        }

        $currentTimestamp = strtotime(gmdate('Y-m-d H:i:s')) + (8 * 3600); // Waktu sekarang dalam UTC+8 (GMT+8)

        $data = DB::table('tb_schedule')
            ->select('nama_schedule', 'time', 'status', 'schedule_condition')
            ->where('time', '>', $currentTimestamp)
            ->join('tb_device', 'tb_schedule.device_id', '=', 'tb_device.device_id')
            ->where('tb_device.device_id', $device_id)
            ->orderBy('time', 'asc')
            ->first();


        session(['device_id' => $device_id]);


        // return $data2;
        return view('manage.schedule.4-channel.index-schedule', [
            'title' => 'Status'
        ])->with('groupedSchedules', $groupedSchedules)
            // ->with('data_manage_schedule', $data1)
            ->with('upcoming', $data)
            ->with('device_id', $device_id)
            ->with('device_name', $device_name);
    }

    public function getFormattedTime($time)
    {
        $carbonTime = Carbon::createFromTimestamp($time);
        $formattedTime = $carbonTime->format('D H:i:s');
        $formattedTime = str_replace(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'], $formattedTime);
        return $formattedTime;
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
        // Validasi Input
        $request->validate([
            'nama_schedule' => 'required',
            'time' => 'required',
        ], [
            'nama_schedule.required' => 'The schedule name field is required.',
            'time.required' => 'The time field is required.',
        ]);

        // Mendapatkan ID Perangkat dari Session
        $device_id_session = session('device_id');

        // Mendapatkan Nilai Input dari Request
        $nama_schedule = $request->input('nama_schedule');
        $time = $request->input('time');
        $status = $request->input('status');
        $option = $request->input('option');
        $hari = [];

        $largestScheduleGroup = ManageScheduleModel::max('schedule_group');
        $schedule_group = $largestScheduleGroup + 1;

        // Pengolahan Pilihan Hari
        if ($option === 'once') {
            // Jika pilihan adalah "once", tambahkan "hari_ini" ke array hari
            $hari[] = 'hari_ini';
            $schedule_condition = 'once';
        } elseif ($option === 'repeat') {
            // Jika pilihan adalah "repeat", ambil nilai array dari inputan "hari"
            $hari = $request->input('hari');
            // Periksa apakah checkbox "repeat_weekly" dicentang, jika iya, set kondisi jadwal menjadi "repeat", jika tidak, set kondisi jadwal menjadi "once"
            $schedule_condition = $request->has('repeat_weekly') ? 'repeat' : 'once';
        }

        // Perulangan dan Penyimpanan Data
        foreach ($hari as $selectedHari) {
            // Mendapatkan tanggal berdasarkan pilihan hari
            $currentDate = Carbon::now();
            $tanggal = $this->getTanggalByHari($selectedHari, $currentDate);

            // Konversi tanggal dan waktu ke epoch time
            $epochTime = $this->convertToEpoch($tanggal, $time);

            // Membuat instance dari model dan menyimpan data
            $schedule = new ManageScheduleModel();
            $schedule->device_id = $device_id_session;
            $schedule->nama_schedule = $nama_schedule;
            $schedule->time = $epochTime;
            $schedule->status = $status;
            $schedule->schedule_condition = $schedule_condition;
            $schedule->schedule_group = $schedule_group;
            $schedule->save();
        }

        // Redirect ke halaman manage-schedule dengan ID perangkat dan memberikan pesan sukses
        return redirect()->to('manage-schedule/' . $device_id_session)->with('success', 'Successfully added the schedule!');
    }

    private function getTanggalByHari($hari, $currentDate)
    {
        // Jika pilihan hari adalah "hari_ini", kembalikan tanggal hari ini
        if ($hari === 'hari_ini') {
            return $currentDate->format('Y-m-d');
        }

        // Jika pilihan hari adalah hari selain "hari_ini", cari tanggal berikutnya berdasarkan nama hari
        $selectedDay = Carbon::parse($hari)->isoFormat('dddd');
        $nextDate = $this->getNextAvailableDate($selectedDay, $currentDate);
        $tanggal = $nextDate->format('Y-m-d');

        return $tanggal;
    }

    private function getNextAvailableDate($selectedDay, $currentDate)
    {
        // Mendapatkan tanggal berikutnya berdasarkan nama hari
        $nextDate = $currentDate->copy();

        while ($nextDate->isoFormat('dddd') !== $selectedDay) {
            $nextDate = $nextDate->addDay();
        }

        return $nextDate;
    }

    private function convertToEpoch($tanggal, $time)
    {
        $dateTime = $tanggal . ' ' . $time;
        $epochTime = Carbon::parse($dateTime)->timestamp;

        return $epochTime;
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

        $schedules = ManageScheduleModel::where('device_id', $session_device_id)->select('schedule_group', 'nama_schedule', 'status', 'time', 'schedule_condition')
            ->groupBy('schedule_group', 'nama_schedule', 'status', 'time', 'schedule_condition')
            ->get();

        $groupedSchedules = [];

        foreach ($schedules as $schedule) {
            $formattedTime = $this->getFormattedTime($schedule->time);
            $groupedSchedules[$schedule->schedule_group][] = [
                'nama_schedule' => $schedule->nama_schedule,
                'time' => $formattedTime,
                'status' => $schedule->status,
                'schedule_condition' => $schedule->schedule_condition,
            ];
        }

        $device_name = ManageDeviceModel::where('device_id', $session_device_id)->value('device_name');

        $data1 = ManageScheduleModel::where('schedule_group', $id)->first();
        $data3 = ManageScheduleModel::where('schedule_group', $id)->get();


        $currentTimestamp = strtotime(gmdate('Y-m-d H:i:s')) + (8 * 3600); // Waktu sekarang dalam UTC+8 (GMT+8)

        $data = DB::table('tb_schedule')
            ->select('nama_schedule', 'time', 'status', 'schedule_condition')
            ->where('time', '>', $currentTimestamp)
            ->join('tb_device', 'tb_schedule.device_id', '=', 'tb_device.device_id')
            ->where('tb_device.device_id', $session_device_id)
            ->orderBy('time', 'asc')
            ->first();

        $datetimeArray = [];
        foreach ($data3 as $schedule) {
            $datewaktu = Carbon::createFromTimestamp($schedule->time)->setTimezone('Asia/Singapore');
            $tanggal = $datewaktu->format('Y-m-d');
            $time = $datewaktu->format('H:i:s');

            $datetimeArray[] = [
                'tanggal' => $tanggal,
            ];
        }

        // return $datetimeArray;
        return view('manage.schedule.4-channel.index-schedule', [
            'title' => 'Manage Device',
        ])
            ->with('edit_schedule', $data1)
            ->with('upcoming', $data)
            ->with('groupedSchedules', $groupedSchedules)
            ->with('device_name', $device_name)
            ->with('device_id', $session_device_id)
            ->with('datetimeArray', $datetimeArray)
            ->with('time', $time);
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
            'time' => 'required',
        ], [
            'nama_schedule.required' => 'The schedule name field is required.',
            'time.required' => 'The time field is required.',
        ]);

        $schedule = ManageScheduleModel::findOrFail($id);

        $schedule->nama_schedule = $request->input('nama_schedule');
        $schedule->time = $this->convertToEpoch($schedule->tanggal, $request->input('time'));
        $schedule->status = $request->input('status');
        $option = $request->input('option');
        $hari = [];

        if ($option === 'once') {
            $hari[] = 'hari_ini';
            $schedule->schedule_condition = 'once';
        } elseif ($option === 'repeat') {
            $hari = $request->input('hari');
            $schedule->schedule_condition = $request->has('repeat_weekly') ? 'repeat' : 'once';
        }

        // Hapus jadwal sebelumnya jika ada
        $schedule->schedules()->delete();

        foreach ($hari as $selectedHari) {
            $currentDate = Carbon::now();
            $tanggal = $this->getTanggalByHari($selectedHari, $currentDate);
            $epochTime = $this->convertToEpoch($tanggal, $request->input('time'));

            $newSchedule = new ManageScheduleModel();
            $newSchedule->device_id = $schedule->device_id;
            $newSchedule->nama_schedule = $schedule->nama_schedule;
            $newSchedule->time = $epochTime;
            $newSchedule->status = $schedule->status;
            $newSchedule->schedule_condition = $schedule->schedule_condition;

            $schedule->schedules()->save($newSchedule);
        }


        $schedule->save();

        return redirect()->to('manage-schedule/' . $schedule->device_id)->with('success', 'Schedule updated successfully!');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($scheduleGroup)
    {
        ManageScheduleModel::where('schedule_group', $scheduleGroup)->delete();

        return redirect()->back()->with('success', 'Schedule has been successfully deleted!');
    }


    public function jam()
    {
        date_default_timezone_set('Asia/Singapore');
        $time = date('H:i:s', time());
        echo $time;
    }

    public function ubahstatus(Request $request)
    {
        date_default_timezone_set('Asia/Singapore');
        $local_time = time();

        $session_device_id = session('device_id');
        $device = ManageDeviceModel::where('device_id', $session_device_id)->first();

        if ($device) {
            $mac_address = $device->mac_address;

            $relay = ManageRelayModel::whereHas('device', function ($query) use ($mac_address) {
                $query->where('mac_address', $mac_address);
            })->first();

            if ($relay) {
                $device_id_relay = $relay->device_id;

                $data = ManageScheduleModel::where('device_id', $session_device_id)->orderBy('schedule_id', 'asc')->get();

                foreach ($data as $schedule) {
                    $schedule_id = $schedule->schedule_id;
                    $device_id = $schedule->device_id;
                    $time = $schedule->time;
                    $status = $schedule->status;
                    $condition = $schedule->schedule_condition;

                    if ($device_id == $session_device_id) {
                        if ($local_time == $time) {
                            ManageRelayModel::where('device_id', $device_id_relay)->update(['switch' => $status]);
                            if ($condition == 'once') {
                                $schedule->where('schedule_id', $schedule_id)->delete();
                            } elseif ($condition == 'repeat') {
                                $newDate = Carbon::createFromTimestamp($schedule->time)->addWeeks(1); // Tambahkan 1 minggu
                                $schedule->where('schedule_id', $schedule_id)->update(['time' => $newDate->timestamp]);
                            }
                        }
                        // elseif ($time == $jam2) {
                        //     ManageRelayModel::where('device_id', $device_id_relay)->update(['switch' => $newSwitchValue]);
                        // }
                    }
                }
            }
        }
    }
}
