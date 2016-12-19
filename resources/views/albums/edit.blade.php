@extends('layouts.app')

@section('scripts')
@endsection

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <div class="form-group">

            <input type="hidden" name="id" value="{{$album ? $album->id : ''}}">

            <div class="album-band">
                <label for="band">Band Name:</label>
                <select id="band-search" name="band" class="band-search form-control" style="width:100%;" autocomplete="off" data-band-id="{{$album->band ? $album->band->id : ''}}" data-band-name="{{$album->band ? $album->band->name : ''}}"></select>
                <span class="help-block"></span>
            </div>

            <div class="album-name">
                <label for="name">Album Name:</label>
                <input type="text" name="name" class="form-control" value="{{$album->name}}" placeholder="Name of the album...">
                <span class="help-block"></span>
            </div>

            <div class="recorded-date">
                <label for="name">Recorded Date:</label>
                <input type="text" name="recorded-date" class="form-control" value="{{Carbon::parse($album->recorded_date)->format('m/d/Y')}}" placeholder="Recorded date...">
                <span class="help-block"></span>
            </div>

            <div class="release-date">
                <label for="name">Release Date:</label>
                <input type="text" name="release-date" class="form-control" value="{{Carbon::parse($album->release_date)->format('m/d/Y')}}" placeholder="Release date...">
                <span class="help-block"></span>
            </div>

            <div class="number-of-tracks">
                <label for="number-of-tracks">Number of tracks:</label>
                <input type="number" name="number-of-tracks" class="form-control" value="{{$album->number_of_tracks}}" placeholder="Number of tracks...">
                <span class="help-block"></span>
            </div>

            <div class="album-label">
                <label for="album-label">Label:</label>
                <input type="text" name="album-label" class="form-control" value="{{$album->label}}" placeholder="Label...">
                <span class="help-block"></span>
            </div>

            <div class="producer">
                <label for="name">Producer:</label>
                <input type="text" name="producer" class="form-control" value="{{$album->producer}}" placeholder="Producer...">
                <span class="help-block"></span>
            </div>

            <div class="genre">
                <label for="genre">Genre:</label>
                <input type="text" name="genre" class="form-control" value="{{$album->genre}}" placeholder="Genre...">
                <span class="help-block"></span>
            </div>

            <p><span id="save-album-message"></span></p>

            <button class="btn btn-success" id="save-album"><i class="fa fa-floppy-o"></i> Save</button>
            <a class="btn btn-danger pull-right" href="/albums"><i class="fa fa-ban"></i> Cancel</a>

        </div>
    </div>
@stop