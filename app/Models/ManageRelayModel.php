<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageRelayModel extends Model
{
    use HasFactory;
    protected $fillable = ['relay_id', 'switch1', 'switch2', 'switch3', 'switch4'];
    protected $table = 'tb_relay';

    // public $timestamps = false;
}
