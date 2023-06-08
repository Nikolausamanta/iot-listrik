<?php

namespace App\Http\Controllers;

use App\Models\MacAddress;
use App\Models\MacAddressModel;
use Illuminate\Support\Facades\View;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AddDeviceController extends Controller
{
    //

    public function index(Request $request)
    {
        $macAddress = MacAddressModel::orderBy('id', 'desc')->first();

        return view('manage.device.alldevice.create', [
            'title' => 'Add Device',
            'macAddress' => $macAddress
        ]);
    }

    public function getData()
    {
        $macAddresses = MacAddressModel::orderBy('id', 'desc')->first();

        return response()->json($macAddresses);
    }

    public function sendMacAddress(Request $request)
    {
        $macAddress = new MacAddressModel();
        $macAddress->mac_address = $request->input('mac_address');
        $macAddress->save();

        return response()->json(['message' => 'Mac address Sudah Simpan DB']);
    }
}
