<script type="text/javascript">

    $(document).ready(function() {

        var tbOrigTrib = $('#tbOrigTrib').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            ajax: '{{ route('execfila.getdataOrigTrib') }}',
            select: {
                style: 'multi',
                info:false
            },
            columns: [
                {data: 'REGTABNM', name: 'REGTABNM'},
                {
                    data: 'REGTABID',
                    name: 'REGTABID',
                    "visible": false,
                    "searchable": false
                },
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

        tbOrigTrib.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var OrigTribId = tbOrigTrib.rows( indexes ).data().pluck( 'REGTABID' );
                $('#formFiltroParcela').append('<input type="hidden" id="OrigTribId'+OrigTribId[0]+'" name="OrigTribId[]" value='+OrigTribId[0]+' />');
            }
        }).on( 'deselect', function ( e, dt, type, indexes ){
            if ( type === 'row' ) {
                var OrigTribId = tbOrigTrib.rows( indexes ).data().pluck( 'REGTABID' );
                $( "#OrigTribId"+OrigTribId[0] ).remove();
            }
        });

    }); // document ready


</script>