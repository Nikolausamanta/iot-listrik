<?php

namespace App\Http\Controllers;

use App\Models\ManageStatusModel;
use App\Models\ManageRelayModel;

use Illuminate\Http\Request;

class ManageRelayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $relay_id = 2;
        // $dddd = ManageRelayModel::where('relay_id', $relay_id)->pluck('switch');
        // return $dddd[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function send()
    {
        $relay_id = 1;
        $dddd = ManageRelayModel::where('relay_id', $relay_id)->pluck('switch');
        return $dddd[0];
    }


    public function relay($value)
    {
        // $status = new $value;
        // $values = [
        //     'switch' => $relay = '1',
        // ];
        // return $values;
        // return $value;
        // $relay = 2;
        // return 'switch' . $relay;
        // $relayId = 1;
        // $value = 'off';
        $relay_id = 1;
        if ($value == "on") {
            ManageRelayModel::where('relay_id', $relay_id)->update(['switch' => 1]);
            $hasil = 1;
        } else {
            ManageRelayModel::where('relay_id', $relay_id)->update(['switch' => 0]);
            $hasil = 0;
        }

        return $hasil;





        // $userId = 1;
        // if ($userId) {
        //     if ($value == "on") {
        //         ManageRelayModel::where('relay_id', $relayId)->update(['switch' => 1]);
        //         $hasil = 1;
        //     } else {
        //         ManageRelayModel::where('relay_id', $relayId)->update(['switch' => 0]);
        //         $hasil = 0;
        //     }
        // } else {
        //     # code...
        // }
        // return $hasil;



        // if ($value == "on") {
        //     $data = ManageRelayModel::where('relay_id', $relayId)->update(['switch' . $relay => 1]);
        // } elseif ($value == "off") {
        //     $data = ManageRelayModel::where('relay_id', $relayId)->update(['switch' . $relay => 0]);
        // } else {
        //     return;
        // }




        // ManageRelayModel::where('relay_id', '1')->update($values);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create()
    {
        $data = 1;
        // $data = ManageRelayModel::where('relay_id', 1)->pluck('switch3');
        return $data;
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
