<script type="text/javascript">

    $(document).ready(function() {


        var tbFxValor = $('#tbFxValor').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            ajax: '{{ route('execfila.getdataFxValor') }}',
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

        tbFxValor.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var FxValorId = tbFxValor.rows( indexes ).data().pluck( 'REGTABID' );
                $('#formFiltroParcela').append('<input type="hidden" id="FxValorId'+FxValorId[0]+'" name="FxValorId[]" value='+FxValorId[0]+' />');
            }
        })
            .on( 'deselect', function ( e, dt, type, indexes ){
                if ( type === 'row' ) {
                    var FxValorId = tbFxValor.rows( indexes ).data().pluck( 'REGTABID' );
                    $( "#FxValorId"+FxValorId[0] ).remove();
                }
            });

    }); // document ready


</script>