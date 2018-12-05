<script type="text/javascript">

    $(document).ready(function() {

        var tbSitPag = $('#tbSitPag').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            ajax: '{{ route('execfila.getdataSitPag') }}',
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

        tbSitPag.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var SitPagId = tbSitPag.rows( indexes ).data().pluck( 'REGTABID' );
                $('#formFiltroParcela').append('<input type="hidden" id="SitPagId'+SitPagId[0]+'" name="SitPagId[]" value='+SitPagId[0]+' />');
            }
        }).on( 'deselect', function ( e, dt, type, indexes ){
            if ( type === 'row' ) {
                var SitPagId = tbSitPag.rows( indexes ).data().pluck( 'REGTABID' );
                $( "#SitPagId"+SitPagId[0] ).remove();
            }
        });

    }); // document ready


</script>