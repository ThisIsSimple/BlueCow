<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function input(Request $request)
    {
        $trashcan_id = $request->input('id');
        $in = $request->input('in');
        $humidity = $request->input('humi');
        $ultrawave = $request->input('uw');
        $weight = $request->input('w');

        $trash = \App\Trashcan::find($trashcan_id)->trashs()->create([
            'in' => $in,
            'humidity' => $humidity,
            'ultrawave' => $ultrawave,
            'weight' => $weight,
        ]);

        return [
            'trashcan_id' => $trashcan_id,
            'in' => $in,
            'humidity' => $humidity,
            'ultrewave' => $ultrawave,
            'weight' => $weight,
            'created_at' => $trash->created_at
        ];
    }
}
