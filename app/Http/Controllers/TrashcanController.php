<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrashcanController extends Controller
{
    public function index()
    {
        return view('trashcan');
    }

    public function get()
    {
        $array = [];

        $trashcans = \App\Trashcan::all();

        foreach($trashcans as $trashcan)
        {
            $latestTrash = \App\Trash::where('trashcan_id', $trashcan->id)->orderBy('created_at', 'desc')->take(1)->get();

            $item = [
                'trashcan_id' => $trashcan->id,
                'height' => $trashcan->height,
                'area' => $trashcan->area,
                'capacity' => $trashcan->capacity,
                'address' => $trashcan->address,
                'latitude' => $trashcan->latitude,
                'longitude' => $trashcan->longitude,

                'trash_id' => $latestTrash[0]->id,
                'in' => $latestTrash[0]->in,
                'out' => $latestTrash[0]->out,
                'humidity' => $latestTrash[0]->humidity,
                'ultrawave' => $latestTrash[0]->ultrawave,
                'weight' => $latestTrash[0]->weight,
            ];

            array_push($array, $item);
        }

        return $array;
    }

    public function add()
    {
        return view('trashcan_add');
    }

    public function db_add(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $address = $request->input('address');
        $height = $request->input('height');
        $area = $request->input('area');
        $capacity = $request->input('capacity');
        $pid = $request->input('pid');
        $name = $request->input('name');

        if(empty($name)) {
            $name = str_random(30);
        }

        $addTrashcan = \App\Trashcan::create([
            'latitude' => $latitude,
            'longitude' => $longitude,
            'address' => $address,
            'height' => $height,
            'area' => $area,
            'capacity' => $capacity,
            'pid' => $pid
        ]);

        $addTrash = \App\Trashcan::find($addTrashcan->id)->trashs()->create([
            'in' => 0,
            'out' => 0,
            'humidity' => 0,
            'ultrawave' => 0,
            'weight' => 0
        ]);

        return redirect('/trashcan/add');
    }
}
