<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllDeviceModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'device_id',
        'device_name',
        'mac_address',
        'user_id',
    ];
    protected $table = 'tb_device';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
