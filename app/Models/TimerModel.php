<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\ManageRelayModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimerModel extends Model
{
    // use HasFactory;

    protected $table = 'tb_timer';
    protected $primaryKey = 'timer_id';
    protected $fillable = ['relay_id', 'device_id', 'duration', 'end_time', 'status'];

    public static function createOrUpdate($deviceId, $duration, $status)
    {
        $timer = TimerModel::where('device_id', $deviceId)->first();

        if ($timer) {
            $timer->update([
                'duration' => $duration,
                'end_time' => Carbon::now()->addSeconds($duration),
                'status' => $status,
            ]);
        } else {
            TimerModel::create([
                'device_id' => $deviceId,
                'duration' => $duration,
                'end_time' => Carbon::now()->addSeconds($duration),
                'status' => $status,
            ]);
        }
    }

    public function cancelTimer()
    {
        $this->end_time = null;
        $this->save();
    }

    public function getRemainingTime()
    {
        if ($this->end_time) {
            $remaining = Carbon::now()->diffInSeconds($this->end_time, false);
            return max(0, $remaining);
        }

        return 0;
    }

    public function getRemainingHours()
    {
        $hours = floor($this->getRemainingTime() / 3600);
        return str_pad($hours, 2, '0', STR_PAD_LEFT); // Mengubah format menjadi dua digit dengan padding nol di depan jika diperlukan
    }

    public function getRemainingMinutes()
    {
        $minutes = floor(($this->getRemainingTime() % 3600) / 60);
        return str_pad($minutes, 2, '0', STR_PAD_LEFT); // Mengubah format menjadi dua digit dengan padding nol di depan jika diperlukan
    }

    public function getRemainingSeconds()
    {
        $seconds = $this->getRemainingTime() % 60;
        return str_pad($seconds, 2, '0', STR_PAD_LEFT); // Mengubah format menjadi dua digit dengan padding nol di depan jika diperlukan

    }
}
