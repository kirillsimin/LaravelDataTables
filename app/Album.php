<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $guarded = ['id'];

    /**
    * Eloquent relationship to bands
    * @return Eloquen relationship
    */
    public function band()
    {
        return $this->belongsTo('App\Band', 'band_id');
    }

    /**
    * Prepared left join statement for the datatables related search
    * @return Albums with left joined bands by band id
    */
    public function withBands()
    {
        return $this->leftJoin('bands', 'bands.id', '=', 'albums.band_id');
    }

    /**
    * Perform search from Datatables
    *
    * @param $request, instance of Request
    * @return Eloquent model
    */
    public function search($request)
    {
        return $this->whereHas('band', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%'.$request->search['value'].'%')
                        ->orWhere('name', 'CONTAINS', '%'.$request->search['value'].'%');
                })
                ->orWhere('albums.name', 'LIKE', '%'.$request->search['value'].'%')
                ->orWhere('albums.name', 'CONTAINS', '%'.$request->search['value'].'%')
                ->orWhere('label', 'LIKE', '%'.$request->search['value'].'%')
                ->orWhere('label', 'CONTAINS', '%'.$request->search['value'].'%')
                ->orWhere('producer', 'LIKE', '%'.$request->search['value'].'%')
                ->orWhere('producer', 'CONTAINS', '%'.$request->search['value'].'%')
                ->orWhere('genre', 'LIKE', '%'.$request->search['value'].'%')
                ->orWhere('genre', 'CONTAINS', '%'.$request->search['value'].'%');
    }
}
