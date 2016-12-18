<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

class BandController extends Controller
{
    public function index()
    {
        return view('bands.index', [

                ]);
    }
}
