<script type="text/javascript">

    $(document).ready(function() {

        var tbSitCob = $('#tbSitCob').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            ajax: '{{ route('execfila.getdataSitCob') }}',
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

        tbSitCob.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var SitCobId = tbSitCob.rows( indexes ).data().pluck( 'REGTABID' );
                $('#formFiltroParcela').append('<input type="hidden" id="SitCobId'+SitCobId[0]+'" name="SitCobId[]" value='+SitCobId[0]+' />');
            }
        }).on( 'deselect', function ( e, dt, type, indexes ){
            if ( type === 'row' ) {
                var SitCobId = tbSitCob.rows( indexes ).data().pluck( 'REGTABID' );
                $( "#SitCobId"+SitCobId[0] ).remove();
            }
        });

    }); // document ready


</script>