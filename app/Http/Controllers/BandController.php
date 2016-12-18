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
        return view('bands.index');
    }

    public function data(Request $request)
    {
        if ($request->search) {
            $bands = Band::where('name', 'LIKE', '%'.$request->search['value'].'%');
        } else {
            $bands = Band::all();
        }

        $datatables = Datatables::of($bands)
        ->editColumn('still_active', function($bands) {
            if ($bands->still_active === 1) {
                return 'Active';
            } else {
                return 'Not active';
            }
        })
        ->editColumn('start_date', function($bands) {
            return Carbon::parse($bands->start_date)->format('l jS \\of F Y');
        })
        ->addColumn('action', function ($bands) {
                $edit = '<a class="fa fa-edit" href="' . route('band.edit', $bands->id) . '"></a>&nbsp;&nbsp;';
                $delete = '<a class="fa fa-trash-o" href="#"></a>&nbsp;&nbsp;';
                return $edit . $delete;
            })
        ->make(true);

        return $datatables;
    }
}
