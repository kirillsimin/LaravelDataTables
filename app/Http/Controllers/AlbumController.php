<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;

use Carbon;
use Yajra\Datatables\Datatables;
use App\Band;
use App\Album;


class AlbumController extends Controller
{
    /**
    * Displays the albums index page
    * @return View
    */
    public function index()
    {
        return view('albums.index', []);
    }

    /**
    * Processes datatables Ajax requests
    * @param $request, Request instance
    * @return $datatables, Datatables Object
    */
    public function data(Request $request)
    {
        $albums = Album::with('band');

        // Filter from search box
        if (!empty($request->search['value'])) {
            $albums = $albums->whereHas('band', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%'.$request->search['value'].'%')
                        ->orWhere('name', 'CONTAINS', '%'.$request->search['value'].'%');
                    })
                ->orWhere('name', 'LIKE', '%'.$request->search['value'].'%')
                ->orWhere('name', 'CONTAINS', '%'.$request->search['value'].'%')
                ->orWhere('label', 'LIKE', '%'.$request->search['value'].'%')
                ->orWhere('label', 'CONTAINS', '%'.$request->search['value'].'%')
                ->orWhere('producer', 'LIKE', '%'.$request->search['value'].'%')
                ->orWhere('producer', 'CONTAINS', '%'.$request->search['value'].'%')
                ->orWhere('genre', 'LIKE', '%'.$request->search['value'].'%')
                ->orWhere('genre', 'CONTAINS', '%'.$request->search['value'].'%');
        }

        // Filter from the bands dropdown
        if ($request->has('band_id')) {
            $albums = $albums->whereHas('band', function ($query) use ($request){
                $query->where('id', $request->band_id);
            });
        }

        // Process datatables object
        $datatables = Datatables::of($albums)
        ->editColumn('band', function($albums) {
            return $albums->band->name;
        })
        ->editColumn('recorded_date', function($albums) {
            return Carbon::parse($albums->recorded_date)->format('l jS \\of F Y');
        })
        ->editColumn('release_date', function($albums) {
            return Carbon::parse($albums->release_date)->format('l jS \\of F Y');
        })
        ->addColumn('action', function ($albums) {
                $edit = '<a class="fa fa-edit" href="' . route('album.edit', $albums->id) . '"></a>&nbsp;&nbsp;';
                $delete = '<i class="delete-album fa fa-trash-o" data-album-id="'.$albums->id.'" data-toggle="modal" data-target="#warning-modal">&nbsp;&nbsp;';
                return $edit . $delete;
            })
        ->make(true);

        return $datatables;
    }

    /**
    * Processes Ajax request to delete an album
    * @param $request, Request instance
    * @return JSON
    */
    public function delete(Request $request)
    {
        $band = Album::findOrFail($request->album_id);
        if ($band->delete()) {
            return json_encode(['success' => true, 'message' => 'Album deleted.']);
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
        $album = Album::firstOrNew(['id' => $request->id]);
        return view('albums.edit', [
            'album' => $album
            ]);
    }

    /**
    * Save album
    * @param $request, Request instance
    * @return Json
    */
    public function save(Request $request)
    {
        $rules = [
            'name' => 'required',
            // 'number_of_tracks' => 'numeric' // (EXAMPLE)
            // There needs to be validation for dates,
            // number of tracks being numeric,
            // needs to check whether the submitted id for band is valid, etc...
        ];
        $messages = [
            'name.required' => 'Album must have a name.',
            // 'number_of_tracks.numeric' => 'This needs to be a number.', // (EXAMPLE)
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $album = Album::firstOrNew(['id' => $request->id]);

        // since we're not validating, I'm inserting nulls where there's no value
        $album->band_id             = $request->band_id; // lack of this will throw an error beacause of the foreign constraint
        $album->name                = $request->name;
        $album->recorded_date       = Carbon::parse($request->recorded_date);
        $album->release_date        = Carbon::parse($request->release_date);
        $album->number_of_tracks    = $request->number_of_tracks ? $request->number_of_tracks : null;
        $album->label               = $request->album_label ? $request->album_label : null;
        $album->producer            = $request->producer ? $request->producer : null;
        $album->genre               = $request->genre ? $request->genre : null;

        if ($album->save()) {
            return json_encode(['success' => true, 'message' => 'Album information successfully saved.', 'album_id' => $album->id]);
        }

        return json_encode(['success' => false, 'message' => 'Could not save information.']);
    }
}
