<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\Band;

class BandController extends Controller
{
    public function index()
    {
        return view('bands.index', []);
    }

    public function data(Request $request)
    {
        $bands = Band::all();
        $datatables = Datatables::of($bands)->make(true);

        return $datatables;
    }
}
