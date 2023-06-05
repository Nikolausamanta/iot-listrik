<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageScheduleModel extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'nama_schedule', 'waktu1', 'waktu2', 'tanggal1', 'status'];
    protected $table = 'tb_schedule';
    // public $timestamps = false;

    // protected $casts = ['tanggal' => 'datetime'];
}
