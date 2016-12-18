<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use App\Band;
use App\Album;


class AlbumController extends Controller
{
    public function index()
    {
        return view('albums.index', []);
    }

    public function data(Request $request)
    {
        if ($request->search) {
            $albums = Album::with('band')
            ->where('name', 'LIKE', '%'.$request->search['value'].'%')
            ->get();
        } else {
            $albums = Album::with('band')->get();
        }

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
                $delete = '<a class="fa fa-trash-o" href="#"></a>&nbsp;&nbsp;';
                return $edit . $delete;
            })
        ->make(true);

        return $datatables;
    }
}
