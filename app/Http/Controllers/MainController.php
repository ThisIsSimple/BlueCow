<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $trashcans = \App\Trashcan::class;

//        $sido = $_COOKIE['sido']?$_COOKIE['sido']:"";
//        $sigugun = $_COOKIE['sigugun']?$_COOKIE['sigugun']:"";
//        $dongmyun = $_COOKIE['dongmyun']?$_COOKIE['dongmyun']:"";

        if(!empty($_COOKIE['sido'])) {
            $sido = $_COOKIE['sido'];
        } else {
            $sido = "";
        }

        if(!empty($_COOKIE['sigugun'])) {
            $sigugun = $_COOKIE['sigugun'];
        } else {
            $sigugun = "";
        }

        if(!empty($_COOKIE['dongmyun'])) {
            $dongmyun = $_COOKIE['dongmyun'];
        } else {
            $dongmyun = "";
        }

        return view('main', [
            'trashcans' => $trashcans::all(),
            'trashcanCount' => $trashcans::all()->count(),
            'request' => $request,
            'trashcanNear' => $trashcans::where('address', 'like', '%'.$sido.'%')->where('address', 'like', '%'.$sigugun.'%')->where('address', 'like', '%'.$dongmyun.'%')->count(),
        ]);
    }
}
