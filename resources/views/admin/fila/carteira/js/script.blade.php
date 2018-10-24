<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tbCarteira = $('#tbCarteira').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            ajax: '{{ route('carteira.getdataCarteira') }}',
            select: {
                style: 'multi',
                info:false
            },
            columns: [
                {data: 'CARTEIRAORD', name: 'CARTEIRAORD'},
                {data: 'CARTEIRASG', name: 'CARTEIRASG'},
                {
                    data: 'CARTEIRAID',
                    name: 'CARTEIRAID',
                    "visible": false,
                    "searchable": false
                },
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });
        tbCarteira.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var CARTEIRAID = tbCarteira.rows( indexes ).data().pluck( 'CARTEIRAID' );
                $('#formFiltroParcela').append('<input type="hidden" id="CARTEIRAID'+CARTEIRAID[0]+'" name="CARTEIRAID[]" value='+CARTEIRAID[0]+' />');
            }
        })
            .on( 'deselect', function ( e, dt, type, indexes ){
                if ( type === 'row' ) {
                    var CARTEIRAID = tbCarteira.rows( indexes ).data().pluck( 'CARTEIRAID' );
                    $( "#CARTEIRAID"+CARTEIRAID[0] ).remove();
                }
            });



    });
</script>
