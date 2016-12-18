$(document).ready(function () {

    /**
    * Bands datatable
    *****************************************************************/
    var oTable = $('#bands').DataTable({
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
    var oTable = $('#albums').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: window.location.origin + '/albums/data',
        },
        columns: [
            {data: 'band', name: 'band.name'},
            {data: 'name', name: 'albums.name'},
            {data: 'recorded_date', name: 'albums.recorded_date'},
            {data: 'release_date', name: 'albums.release_date'},
            {data: 'number_of_tracks', name: 'albums.number_of_tracks'},
            {data: 'label', name: 'albums.label'},
            {data: 'producer', name: 'albums.producer'},
            {data: 'genre', name: 'albums.genre'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

});