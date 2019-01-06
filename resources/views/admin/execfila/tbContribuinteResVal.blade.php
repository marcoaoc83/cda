<script type="text/javascript">

    $(document).ready(function() {

        var  tbContribuinteResVal = $('#tbContribuinteResVal').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('execfila.getDadosTratRetorno') }}'+"/?none=1",
            select: {
                style: 'multi',
                info:false
            },
            columns: [
                {data: 'Nome', name: 'Nome'},
                {data: 'CPFCNPJ', name: 'CPFCNPJ'},
                {
                    data: 'PessoaId',
                    name: 'PessoaId',
                    "visible": false,
                    "searchable": false
                },
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

         tbContribuinteResVal.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $( ".resIMid" ).remove();
                var ContribuinteResId =  tbContribuinteResVal.rows( indexes ).data().pluck( 'PessoaId' );
                $('#formFiltroParcela').append('<input type="hidden" id="ContribuinteResId'+ContribuinteResId[0]+'" name="ContribuinteResId[]" value='+ContribuinteResId[0]+' />');

                var tbContribuinteResIMVal = $('#tbContribuinteResIMVal').DataTable();
                var url = "{{ route('execfila.getDadosValidarAll') }}"+"/?group=IM&"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val()+'&Canal='+$('#CanalId').val();
                tbContribuinteResIMVal.ajax.url(url).load();

                var tbValidacaoRes = $('#tbValidacaoRes').DataTable();
                var url = "{{ route('execfila.getDadosValidarAll') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val()+'&Canal='+$('#CanalId').val();
                tbValidacaoRes.ajax.url(url).load();
            }
        }).on( 'deselect', function ( e, dt, type, indexes ){
            if ( type === 'row' ) {
                $( ".resIMid" ).remove();
                var ContribuinteResId =  tbContribuinteResVal.rows( indexes ).data().pluck( 'PessoaId' );
                $( "#ContribuinteResId"+ContribuinteResId[0] ).remove();

                var tbContribuinteResIMVal = $('#tbContribuinteResIMVal').DataTable();
                var url = "{{ route('execfila.getDadosValidarAll') }}"+"/?group=IM&"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val()+'&Canal='+$('#CanalId').val();
                tbContribuinteResIMVal.ajax.url(url).load();

                var tbValidacaoRes = $('#tbValidacaoRes').DataTable();
                var url = "{{ route('execfila.getDadosValidarAll') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val()+'&Canal='+$('#CanalId').val();
                tbValidacaoRes.ajax.url(url).load();
            }
        });

    }); // document ready


</script>