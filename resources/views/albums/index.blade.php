@extends('layouts.app')

@section('scripts')
@endsection

@section('content')
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="albums" class="table table-striped">
                <thead>
                    <tr>
                        <th class="td-shrink">Band</th>
                        <th class="td-shrink">Name</th>
                        <th class="td-shrink">Recorded Date</th>
                        <th class="td-shrink">Release Date</th>
                        <th class="td-shrink">Number of Tracks</th>
                        <th class="td-shrink">Label</th>
                        <th class="td-shrink">Producer</th>
                        <th class="td-shrink">Genre</th>
                        <th class="td-shrink">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop