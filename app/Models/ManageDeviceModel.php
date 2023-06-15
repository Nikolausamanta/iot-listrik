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
    protected $primaryKey = 'device_id';

    protected $table = 'tb_device';

    public function relay()
    {
        return $this->hasOne(ManageRelayModel::class, 'device_id');
    }

    public function status()
    {
        return $this->hasOne(ManageStatusModel::class, 'device_id');
    }

    public function relays()
    {
        return $this->hasMany(ManageRelayModel::class, 'device_id');
    }
}
