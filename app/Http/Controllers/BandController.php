<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use Carbon;
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
        $bands = Band::select('name', 'start_date', 'website', 'still_active');

        // Filter from search box
        if (!empty($request->search['value'])) {
            $bands = Band::where('name', 'LIKE', '%'.$request->search['value'].'%')
                ->orWhere('name', 'CONTAINS', '%'.$request->search['value'].'%');
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
                $delete = '<i class="delete-band fa fa-trash-o" data-band-id="'.$bands->id.'" data-toggle="modal" data-target="#warning-modal">&nbsp;&nbsp;';
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

    /**
    * Processes Ajax request to delete a band
    * @param $request, Request instance
    * @return JSON
    */
    public function delete(Request $request)
    {
        $band = Band::findOrFail($request->band_id);
        if ($band->delete()) {
            return json_encode(['success' => true, 'message' => 'Band deleted.']);
        }
        return json_encode(['success' => false, 'message' => 'Something went wrong.']);
    }

    /**
    * Displays the edit/create page
    * @param $request, Request instance
    * @return View
    */
    public function edit(Request $request)
    {
        $band = Band::firstOrNew(['id' => $request->id]);
        return view('bands.edit', [
            'band' => $band
            ]);
    }

    /**
    * Save band
    * @param $request, Request instance
    * @return Json
    */
    public function save(Request $request)
    {
        $rules = [
            'name' => 'required',
            // There needs to be validation for the other fields as well (date, active_url, etc...)
        ];
        $messages = [
            'name.required' => 'Band must have a name.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $band = Band::firstOrNew(['id' => $request->id]);

        // since we're not validating, I'm inserting nulls where there's no value
        $band->name            = $request->name;
        $band->start_date      = Carbon::parse($request->start_date);
        $band->website         = $request->website ? $request->website : null;
        $band->still_active    = $request->still_active ? $request->still_active : null;

        if ($band->save()) {
            return json_encode(['success' => true, 'message' => 'Band information successfully saved.', 'album_id' => $band->id]);
        }

        return json_encode(['success' => false, 'message' => 'Could not save information.']);
    }

}
