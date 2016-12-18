@extends('layouts.app')

@section('scripts')
@endsection

@section('content')
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="bands" class="table table-striped">
                <thead>
                    <tr>
                        <th class="td-shrink">Name</th>
                        <th class="td-shrink">Start Date</th>
                        <th class="td-shrink">Website</th>
                        <th class="td-shrink">Still Active</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop