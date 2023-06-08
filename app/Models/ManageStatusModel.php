<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageStatusModel extends Model
{
    use HasFactory;
    protected $fillable = ['sensor_id', 'device_id', 'voltage', 'current', 'power', 'energy', 'frequency', 'powerFactor', 'switch1', 'switch2', 'switch3', 'switch4'];
    protected $table = 'tb_sensor';
    // public $timestamps = false;
}
