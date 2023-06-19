<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageScheduleModel extends Model
{
    use HasFactory;
    protected $fillable = ['schedule_id', 'device_id', 'schedule_group', 'relay_id', 'nama_schedule', 'time', 'hari', 'schedule_condition', 'status'];
    protected $table = 'tb_schedule';
    protected $primaryKey = 'schedule_id';
    // public $timestamps = false;

    // protected $casts = ['tanggal' => 'datetime'];

    public function device()
    {
        return $this->belongsTo(ManageDeviceModel::class, 'device_id');
    }

    public function schedules()
    {
        return $this->hasMany(ManageScheduleModel::class, 'schedule_group', 'schedule_group');
    }
}
