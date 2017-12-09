<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrashcanController extends Controller
{
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
}
