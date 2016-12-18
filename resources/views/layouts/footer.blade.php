</div>

<div class="col-xs-12 text-center">Copyright @ {{Carbon\Carbon::now()}} </div>

{{-- @if(Auth::check()) --}}
    {!! csrf_field() !!}
{{-- @endif --}}

@include('modals/warning')

</body>
</html>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/select2/4.0.2/js/select2.full.min.js"></script>
<script type="text/javascript" src="{{ elixir('js/app.js') }}"></script>

@yield('scripts')