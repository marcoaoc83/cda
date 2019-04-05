<script type="text/javascript">

    $(document).ready(function() {


        var tbFxAtraso = $('#tbFxAtraso').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            ajax: '{{ route('execfila.getdataFxAtraso') }}',
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
        tbFxAtraso.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var FxAtrasoId = tbFxAtraso.rows( indexes ).data().pluck( 'REGTABID' );
                $('#formFiltroParcela').append('<input type="hidden" id="FxAtrasoId'+FxAtrasoId[0]+'" name="FxAtrasoId[]" value='+FxAtrasoId[0]+' />');
            }
        })
            .on( 'deselect', function ( e, dt, type, indexes ){
                if ( type === 'row' ) {
                    var FxAtrasoId = tbFxAtraso.rows( indexes ).data().pluck( 'REGTABID' );
                    $( "#FxAtrasoId"+FxAtrasoId[0] ).remove();
                }
            });


    }); // document ready


</script>