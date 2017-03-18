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
            {data: 'name', name: 'name'},
            {data: 'start_date', name: 'start_date'},
            {data: 'website', name: 'website'},
            {data: 'still_active', name: 'still_active', searchable: false},
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
            {data: 'band_name', name: 'name'},
            {data: 'album_name', name: 'albums.name'},
            {data: 'recorded_date', name: 'recorded_date', searchable: false},
            {data: 'release_date', name: 'release_date', searchable: false},
            {data: 'number_of_tracks', name: 'number_of_tracks', searchable: false},
            {data: 'label', name: 'label'},
            {data: 'producer', name: 'producer'},
            {data: 'genre', name: 'genre'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    $('#band-search').off('change', function(){});
    $('#band-search').on('change', function(e){
        e.preventDefault();
        albumsTable.draw();
    });

    /**
    * Albums Select 2
    *****************************************************************/
    $('#band-search').select2({
        allowClear: true,
        minimumInputLength: 3,
        initSelection: function (element, callback) {
            var bandId = $('#band-search').data('band-id');
            var bandName = $('#band-search').data('band-name');
            callback({ id: bandId, text: bandName});
        },
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
    * Init datepickers
    *****************************************************************/
    $('input[name="recorded-date"').bootstrapMaterialDatePicker({ format : 'MM/DD/YYYY', currentDate: moment()});
    $('input[name="release-date"').bootstrapMaterialDatePicker({ format : 'MM/DD/YYYY', currentDate: moment()});
    $('input[name="start-date"').bootstrapMaterialDatePicker({ format : 'MM/DD/YYYY', currentDate: moment()});

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

    $('#save-album').off('click');
    $('#save-album').on('click', function() {
        var id = $('input[name="id"]').val();
        var token = $('input[name="_token"]').val();
        var bandId = $('#band-search').val();
        if (bandId == null) {
            bandId = $('#band-search').data('band-id'); // select2 doesn't play well with pre-selected Ajax
        }
        var name = $('input[name="name"]').val();
        var recordedDate = $('input[name="recorded-date"]').val();
        var releaseDate = $('input[name="release-date"]').val();
        var numberOfTracks = $('input[name="number-of-tracks"]').val();
        var albumLabel = $('input[name="album-label"]').val();
        var producer = $('input[name="producer"]').val();
        var genre = $('input[name="genre"]').val();
        $.ajax({
            url: '/albums/save',
            method: 'post',
            data: {
                _token: token,
                id: id,
                band_id: bandId,
                name: name,
                recorded_date: recordedDate,
                release_date: releaseDate,
                number_of_tracks: numberOfTracks,
                album_label: albumLabel,
                producer: producer,
                genre: genre
            },
            dataType: 'json'
        })
        .always(function(){
            $('.has-error').removeClass('has-error');
            $('.help-block').html('');
            $('#save-album-message').html('');
        })
        .done(function(data){
            console.log(data);
            if (data.success === true) {
                // populates id with newly created album, so it doesn't get created twice
                $('input[name="id"]').val(data.album_id);
            }
            if (data.name) {
                $('.album-name').addClass('has-error');
                $('.album-name').find('.help-block').html(data.name[0]);
            }
            // example of further validation
            // if (data.number_of_tracks) {
            //     $('.number-of-tracks').addClass('has-error');
            //     $('.number-of-tracks').find('.help-block').html(data.number_of_tracks[0]);
            // }
            $('#save-album-message').html(data.message);
        })
        .fail(function(data){
            $('#save-album-message').html('Something went wrong.');
        });
    });

    $('#save-band').off('click');
    $('#save-band').on('click', function() {
        var id = $('input[name="id"]').val();
        var token = $('input[name="_token"]').val();
        var name = $('input[name="name"]').val();
        var startDate = $('input[name="recorded-date"]').val();
        var website = $('input[name="website"]').val();
        var stillActive = $('input[name="number-of-tracks"]').val();
        $.ajax({
            url: '/bands/save',
            method: 'post',
            data: {
                _token: token,
                id: id,
                name: name,
                start_date: startDate,
                website: website,
                still_active: stillActive
            },
            dataType: 'json'
        })
        .always(function(){
            $('.has-error').removeClass('has-error');
            $('.help-block').html('');
            $('#save-band-message').html('');
        })
        .done(function(data){
            console.log(data);
            if (data.success === true) {
                $('input[name="id"]').val(data.album_id);
            }
            if (data.name) {
                $('.name').addClass('has-error');
                $('.name').find('.help-block').html(data.name[0]);
            }
            $('#save-band-message').html(data.message);
        })
        .fail(function(data){
            $('#save-band-message').html('Something went wrong.');
        });
    });

});
//# sourceMappingURL=app.js.map
