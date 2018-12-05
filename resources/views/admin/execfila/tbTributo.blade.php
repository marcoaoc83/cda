<script type="text/javascript">

    $(document).ready(function() {

        var tbTributo = $('#tbTributo').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            ajax: '{{ route('execfila.getdataTributo') }}',
            select: {
                style: 'multi',
                info:false
            },
            columns: [
                {data: 'REGTABSG', name: 'REGTABSG'},
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

        tbTributo.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var TributoId = tbTributo.rows( indexes ).data().pluck( 'REGTABID' );
                $('#formFiltroParcela').append('<input type="hidden" id="TributoId'+TributoId[0]+'" name="TributoId[]" value='+TributoId[0]+' />');
            }
        }).on( 'deselect', function ( e, dt, type, indexes ){
            if ( type === 'row' ) {
                var TributoId = tbTributo.rows( indexes ).data().pluck( 'REGTABID' );
                $( "#TributoId"+TributoId[0] ).remove();
            }
        });

    }); // document ready


</script>