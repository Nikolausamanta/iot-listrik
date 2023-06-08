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
    protected $fillable = ['relay_id', 'device_id', 'duration', 'end_time'];

    public static function createOrUpdate($deviceId, $duration)
    {
        $timer = TimerModel::where('device_id', $deviceId)->first();

        if ($timer) {
            $timer->update([
                'duration' => $duration,
                'end_time' => Carbon::now()->addSeconds($duration),
            ]);
        } else {
            TimerModel::create([
                'device_id' => $deviceId,
                'duration' => $duration,
                'end_time' => Carbon::now()->addSeconds($duration),
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
        return floor($this->getRemainingTime() / 3600);
    }

    public function getRemainingMinutes()
    {
        return floor(($this->getRemainingTime() % 3600) / 60);
    }

    public function getRemainingSeconds()
    {
        return $this->getRemainingTime() % 60;
    }
}
