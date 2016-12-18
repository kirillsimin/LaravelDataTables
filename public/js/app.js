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

    /**
    * Delete Band
    *****************************************************************/
    $(document).off('click', '.delete-band');
    $(document).on('click', '.delete-band', function() {
        var bandId = $(this).data('band-id');
        $('.warning-modal-yes').off('click');
        $('.warning-modal-yes').on('click', function() {
            var token = $('input[name="_token"]').val();
            $.ajax({
                url: '/bands/delete',
                method: 'post',
                data: {
                    _token: token,
                    band_id: bandId
                },
                dataType: 'json'
            })
            .always(function(){
                $('#warning-modal').find('.message').html('');
            })
            .done(function(data){
                console.log(data);
                if (data.success == true) {
                    $('#warning-modal').modal('hide');
                    bandsTable.draw();
                }
                if (data.success == false) {
                    console.log(data.message);
                    $('#warning-modal').find('.message').html(data.message);
                }
            })
            .fail(function(data){
                $('#warning-modal').find('.message').html('Unexpected error occured.');
                response = JSON.parse(data.responseText);
                console.log(data, response);

            });
        });
    });

    /**
    * Delete Album
    *****************************************************************/
    $(document).off('click', '.delete-album');
    $(document).on('click', '.delete-album', function() {
        var albumId = $(this).data('album-id');
        $('.warning-modal-yes').off('click');
        $('.warning-modal-yes').on('click', function() {
            var token = $('input[name="_token"]').val();
            $.ajax({
                url: '/albums/delete',
                method: 'post',
                data: {
                    _token: token,
                    album_id: albumId
                },
                dataType: 'json'
            })
            .always(function(){
                $('#warning-modal').find('.message').html('');
            })
            .done(function(data){
                console.log(data);
                if (data.success == true) {
                    $('#warning-modal').modal('hide');
                    albumsTable.draw();
                }
                if (data.success == false) {
                    console.log(data.message);
                    $('#warning-modal').find('.message').html(data.message);
                }
            })
            .fail(function(data){
                $('#warning-modal').find('.message').html('Unexpected error');
                response = JSON.parse(data.responseText);
                console.log(data, response);
            });
        });
    });

});
//# sourceMappingURL=app.js.map
