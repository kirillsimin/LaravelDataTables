@extends('layouts.app')

@section('scripts')
@endsection

@section('content')
    <div class="col-md-6 col-md-offset-6 text-right" style="margin-bottom: 10px">
        <a href="{{ route('band.edit') }}" class="btn btn-info"><i class="fa fa-plus"></i> Add Band</a>
    </div>

    <div class="col-md-12">
        <div class="table-responsive">
            <table id="bands" class="table table-striped">
                <thead>
                    <tr>
                        <th class="td-shrink">Name</th>
                        <th class="td-shrink">Start Date</th>
                        <th class="td-shrink">Website</th>
                        <th class="td-shrink">Still Active</th>
                        <th class="td-shrink">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop