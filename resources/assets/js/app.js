$(document).ready(function () {

    /**
    * Bands datatable
    *****************************************************************/
    var bandsTable = $('#bands').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: window.location.origin + '/bands/data',
        },
        columns: [
            {data: 'name', name: 'bands.name'},
            {data: 'start_date', name: 'bands.start_date'},
            {data: 'website', name: 'bands.website'},
            {data: 'still_active', name: 'bands.still_active', searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    /**
    * Albums datatable
    *****************************************************************/
    var albumsTable = $('#albums').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: window.location.origin + '/albums/data',
            data: function (d) {
                d.band_id = $('#band-search').val();
            }
        },
        columns: [
            {data: 'band', name: 'band_id'},
            {data: 'name', name: 'name'},
            {data: 'recorded_date', name: 'recorded_date'},
            {data: 'release_date', name: 'release_date'},
            {data: 'number_of_tracks', name: 'number_of_tracks'},
            {data: 'label', name: 'label'},
            {data: 'producer', name: 'producer'},
            {data: 'genre', name: 'genre'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    $('#band-search').off('select2:select', function(){});
    $('#band-search').on('select2:select', function(e){
        console.log('band-search', $(this).val());
        e.preventDefault();
        albumsTable.draw();
    });

    /**
    * Albums Select 2
    *****************************************************************/
    $('.band-search').select2({
        minimumInputLength: 3,
        placeholder: "Select band...",
        ajax: {
            url: '/bands/search',
            method: 'post',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                var token = $('input[name="_token"]').val();
                return {
                    term: params.term, // search term
                    role_id: 2,
                    _token: token
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            }
        }
    });

});