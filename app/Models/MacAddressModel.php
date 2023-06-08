<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MacAddressModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'mac_address',
    ];

    protected $table = 'tb_mac_address';
}
