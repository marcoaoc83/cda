<script type="text/javascript">

    $(document).ready(function() {


        var tbEventos = $('#tbEventos').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            ajax: '{{ route('execfila.getDadosEventos') }}?fila=0',
            select: {
                style: 'multiple',
                info:false
            },
            columns: [
                {
                    data: 'EventoSg',
                    name: 'EventoSg'
                },
                {
                    data: 'EventoNm',
                    name: 'EventoNm'
                },
                {
                    data: 'EventoId',
                    name: 'EventoId',
                    "visible": false,
                    "searchable": false
                }
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

        tbEventos.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var EventosId = tbEventos.rows( indexes ).data().pluck( 'EventoId' );
                $('#formFiltroParcela').append('<input type="hidden" id="EventosId'+EventosId[0]+'" name="EventosId[]" value='+EventosId[0]+' />');
            }
        }).on( 'deselect', function ( e, dt, type, indexes ){
            if ( type === 'row' ) {
                var EventosId = tbEventos.rows( indexes ).data().pluck( 'EventoId' );
                $( "#EventosId"+EventosId[0] ).remove();
            }
        });
    }); // document ready


</script>