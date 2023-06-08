<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageScheduleModel extends Model
{
    use HasFactory;
    protected $fillable = ['schedule_id', 'device_id', 'relay_id', 'nama_schedule', 'waktu1', 'waktu2', 'tanggal1', 'status'];
    protected $table = 'tb_schedule';
    // public $timestamps = false;

    // protected $casts = ['tanggal' => 'datetime'];
}
