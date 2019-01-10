<script type="text/javascript">

    $(document).ready(function() {

        var  tbContribuinteResIMVal = $('#tbContribuinteResIMVal').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('execfila.getDadosValidarAll') }}'+"/?none=1",
            select: {
                style: 'multi',
                info:false
            },
            columns: [
                {data: 'INSCRMUNNR', name: 'INSCRMUNNR'},
                {
                    data: 'INSCRMUNID',
                    name: 'INSCRMUNID',
                    "visible": false,
                    "searchable": false
                },
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

         tbContribuinteResIMVal.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var ContribuinteResIMId =  tbContribuinteResIMVal.rows( indexes ).data().pluck( 'INSCRMUNID' );
                $('#formFiltroParcela').append('<input type="hidden" class="resIMid" id="ContribuinteResIMId'+ContribuinteResIMId[0]+'" name="ContribuinteResIMId[]" value='+ContribuinteResIMId[0]+' />');
                var tbValidacaoRes = $('#tbValidacaoRes').DataTable();
                var url = "{{ route('execfila.getDadosValidarAll') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val()+'&Canal='+$('#CanalId').val();
                tbValidacaoRes.ajax.url(url).load();
            }
        }).on( 'deselect', function ( e, dt, type, indexes ){
            if ( type === 'row' ) {
                var ContribuinteResIMId =  tbContribuinteResIMVal.rows( indexes ).data().pluck( 'INSCRMUNID' );
                $( "#ContribuinteResIMId"+ContribuinteResIMId[0] ).remove();
                var tbValidacaoRes = $('#tbValidacaoRes').DataTable();
                var url = "{{ route('execfila.getDadosValidarAll') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val()+'&Canal='+$('#CanalId').val();
                tbValidacaoRes.ajax.url(url).load();
            }
        });

    }); // document ready


</script>