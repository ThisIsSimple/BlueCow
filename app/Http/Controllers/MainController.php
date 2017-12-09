<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $trashcans = \App\Trashcan::all();

        return view('main', [
            'trashcans' => $trashcans
        ]);
    }
}
