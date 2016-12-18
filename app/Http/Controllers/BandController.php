<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\Band;

class BandController extends Controller
{
    /**
    * Displays bands index page
    * @return View
    */
    public function index()
    {
        return view('bands.index');
    }

    /**
    * Processes datatables Ajax requests
    * @param $request, Request instance
    * @return $datatables, Datatables Object
    */
    public function data(Request $request)
    {
        $bands = Band::all();

        // Filter from search box
        if (!empty($request->search['value'])) {
            $bands = $bands::where('name', 'LIKE', '%'.$request->search['value'].'%');
        }

        // Process datatables object
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

    /**
    * Processes Ajax search requests from Select2 Dropdown
    * @param $request, Request instance
    * @return Array
    */
    public function search(Request $request)
    {
        return Band::select('id', 'name AS text')
            ->where('name', 'LIKE', '%'.$request->term.'%')
            ->orWhere('name', 'CONTAINS', '%'.$request->term.'%')
            ->get()
            ->toArray();
    }
}
