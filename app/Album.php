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
    public static function withBands()
    {
        return self::select(
            'bands.name AS band_name',
            'albums.*'
        )
        ->leftJoin('bands', 'bands.id', '=', 'albums.band_id');
    }
}
