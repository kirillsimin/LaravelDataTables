<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
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
                ->orWhere('name', 'LIKE', '%'.$request->search['value'].'%');
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
}
