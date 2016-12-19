@extends('layouts.app')

@section('scripts')
@endsection

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <div class="form-group">

            <input type="hidden" name="id" value="{{$band ? $band->id : ''}}">

            <div class="name">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" value="{{$band->name}}" placeholder="Name of the band...">
                <span class="help-block"></span>
            </div>


            <div class="start-date">
                <label for="name">Start Date:</label>
                <input type="text" name="start-date" class="form-control" value="{{Carbon::parse($band->start_date)->format('m/d/Y')}}" placeholder="Recorded date...">
                <span class="help-block"></span>
            </div>

            <div class="website">
                <label for="website">Website:</label>
                <input type="text" name="website" class="form-control" value="{{$band->website}}" placeholder="Label...">
                <span class="help-block"></span>
            </div>

            <div class="producer">
                <label for="name">Still Active:</label>
                <select class="form-control">
                    <option value="1">Acive</option>
                    <option value="0">Not Acive</option>
                </select>
                <span class="help-block"></span>
            </div>

            <p><span id="save-band-message"></span></p>

            <button class="btn btn-success" id="save-band"><i class="fa fa-floppy-o"></i> Save</button>
            <a class="btn btn-danger pull-right" href="/"><i class="fa fa-ban"></i> Cancel</a>

        </div>
    </div>
@stop