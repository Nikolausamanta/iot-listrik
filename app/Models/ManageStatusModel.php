<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageStatusModel extends Model
{
    use HasFactory;
    protected $fillable = ['sensor_id', 'mac_address', 'voltage', 'current', 'power', 'energy', 'frequency', 'powerfactor', 'switch1', 'switch2', 'switch3', 'switch4'];
    protected $table = 'tb_sensor';


    public function device()
    {
        return $this->belongsTo(ManageDeviceModel::class, 'device_id');
    }
    // public $timestamps = false;
}
