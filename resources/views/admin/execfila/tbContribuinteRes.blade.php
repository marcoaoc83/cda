<script type="text/javascript">

    $(document).ready(function() {

        var tbContribuinteRes = $('#tbContribuinteRes').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('execfila.getdataParcela') }}'+"/?limit=0",
            select: {
                style: 'multi',
                info:false
            },
            columns: [
                {data: 'Nome', name: 'Nome'},
                {data: 'CPFCNPJ', name: 'CPFCNPJ'},
                {data: 'INSCRMUNNR', name: 'INSCRMUNNR'},
                {data: 'VencimentoDt', name: 'VencimentoDt'},
                {data: 'TotalVr', name: 'TotalVr'},
                {data: 'FxAtraso', name: 'FxAtraso'},
                {data: 'FxValor', name: 'FxValor'},
                {
                    data: 'PessoaId',
                    name: 'PessoaId',
                    "visible": false,
                    "searchable": false
                },
            ],
            columnDefs: [
                {
                    targets: 3,
                    className: 'text-right'
                }
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

        tbContribuinteRes.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var ContribuinteResId = tbContribuinteRes.rows( indexes ).data().pluck( 'PessoaId' );
                $('#formFiltroParcela').append('<input type="hidden" id="ContribuinteResId'+ContribuinteResId[0]+'" name="ContribuinteResId[]" value='+ContribuinteResId[0]+' />');
                var tbParcela = $('#tbParcela').DataTable();
                var url = "{{ route('execfila.getdataParcela') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
                tbParcela.ajax.url(url).load();
            }
        }).on( 'deselect', function ( e, dt, type, indexes ){
            if ( type === 'row' ) {
                var ContribuinteResId = tbContribuinteRes.rows( indexes ).data().pluck( 'PessoaId' );
                $( "#ContribuinteResId"+ContribuinteResId[0] ).remove();
                var tbParcela = $('#tbParcela').DataTable();
                var url = "{{ route('execfila.getdataParcela') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val();
                tbParcela.ajax.url(url).load();
            }
        });

    }); // document ready


</script>