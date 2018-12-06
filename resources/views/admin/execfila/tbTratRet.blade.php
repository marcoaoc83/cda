<script type="text/javascript">

    $(document).ready(function() {


        var tbTratRet = $('#tbTratRet').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            ajax: '{{ route('execfila.getDadosTratRet') }}?fila=0',
            select: {
                style: 'multiple',
                info:false
            },
            columns: [
                {
                    data: 'RetornoCd',
                    name: 'RetornoCd'
                },

                {
                    data: 'EventoSg',
                    name: 'EventoSg'
                },
                {
                    data: 'RetornoCdNr',
                    name: 'RetornoCdNr'
                },
                {
                    data: 'EventoId',
                    name: 'EventoId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'TratRetId',
                    name: 'TratRetId',
                    "visible": false,
                    "searchable": false
                }
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

        tbTratRet.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var TratRetId = tbTratRet.rows( indexes ).data().pluck( 'EventoId' );
                $('#formFiltroParcela').append('<input type="hidden" id="TratRetId'+TratRetId[0]+'" name="TratRetId[]" value='+TratRetId[0]+' />');
            }
        }).on( 'deselect', function ( e, dt, type, indexes ){
            if ( type === 'row' ) {
                var TratRetId = tbTratRet.rows( indexes ).data().pluck( 'EventoId' );
                $( "#TratRetId"+TratRetId[0] ).remove();
            }
        });
    }); // document ready


</script>