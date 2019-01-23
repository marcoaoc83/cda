<script type="text/javascript">

    $(document).ready(function() {

        var tbIMRes = $('#tbIMRes').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('execfila.getdataParcela') }}'+"/?none=1",
            select: {
                style: 'multi',
                info:false
            },
            columns: [
                {data: 'Nome', name: 'Nome'},
                {data: 'INSCRMUNNR', name: 'INSCRMUNNR'},
                {data: 'VencimentoDt', name: 'VencimentoDt'},
                {data: 'TotalVr', name: 'TotalVr'},
                {data: 'FxAtraso', name: 'FxAtraso'},
                {data: 'FxValor', name: 'FxValor'},
                {
                    data: 'INSCRMUNID',
                    name: 'INSCRMUNID',

                    "visible": false,
                    "searchable": false
                }

            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

        tbIMRes.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var IMRes = tbIMRes.rows( indexes ).data().pluck( 'INSCRMUNID' );
                $('#formFiltroParcela').append('<input type="hidden" class="filtroRes" id="IMRes'+IMRes[0]+'" name="IMRes[]" value='+IMRes[0]+' />');
                var tbParcela = $('#tbParcela').DataTable();
                var url = "{{ route('execfila.getdataParcela') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
                tbParcela.ajax.url(url).load();
            }
        }).on( 'deselect', function ( e, dt, type, indexes ){
            if ( type === 'row' ) {
                var IMRes = tbIMRes.rows( indexes ).data().pluck( 'INSCRMUNID' );
                $( "#IMRes"+IMRes[0] ).remove();
                var tbParcela = $('#tbParcela').DataTable();
                var url = "{{ route('execfila.getdataParcela') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
                tbParcela.ajax.url(url).load();
            }
        });

    }); // document ready


</script>