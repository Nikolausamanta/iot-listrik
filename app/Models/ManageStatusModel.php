<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManageStatusModel extends Model
{
    use HasFactory;
    protected $fillable = ['sensor_id', 'mac_address', 'voltage', 'current', 'power', 'energy', 'frequency', 'powerfactor', 'kwh', 'created_at', 'updated_at'];
    protected $table = 'tb_sensor';
    // protected $dates = ['created_at'];

    public function device()
    {
        return $this->belongsTo(ManageDeviceModel::class, 'device_id');
    }
    // public $timestamps = false;
}
