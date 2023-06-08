<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageDeviceModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'device_id',
        'device_name',
        'mac_address',
        'user_id',
    ];

    protected $table = 'tb_device';
}
