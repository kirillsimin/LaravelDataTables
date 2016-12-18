$(document).ready(function () {
    console.log('h');
    /**
    * Process datatable ajax call
    *****************************************************************/
    var oTable = $('#bands').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: window.location.origin + '/bands/data',
            data: function (d) {
                d.name = $('select[name=name]').val();
                d.start_date = $('select[name=start_date]').val();
                d.website = $('select[name=website]').val();
                // d.still_active = $('select[name=still_active]').val();
            }
        },
        columns: [
            {data: 'name', name: 'bands.name'},
            {data: 'start_date', name: 'bands.start_date'},
            {data: 'website', name: 'bands.website'},
            {data: 'still_active', name: 'bands.still_active', searchable: false}
        ]
    });
});