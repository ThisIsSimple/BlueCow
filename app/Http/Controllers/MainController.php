<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $trashcans = \App\Trashcan::class;

        $sido = $request->cookie("sido");
        $sigugun = $request->cookie("sigugun");
        $dongmyun = $request->cookie("dongmyun");

        return view('main', [
            'trashcans' => $trashcans::all(),
            'trashcanCount' => $trashcans::all()->count(),
            'request' => $request,
            'trashcanNear' => $trashcans::where('address', 'like', '%'.$sido.'%')->where('address', 'like', '%'.$sigugun.'%')->where('address', 'like', '%'.$dongmyun.'%')->count(),
        ]);
    }
}
