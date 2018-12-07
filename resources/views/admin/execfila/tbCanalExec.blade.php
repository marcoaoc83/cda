<script type="text/javascript">

    $(document).ready(function() {


        var tbCanalExec = $('#tbCanalExec').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "paging": false,
            "ordering": false,
            "info": false,
            ajax: "{{ route('execfila.getDadosTratRetorno') }}" + "/?none=1",
            select: {
                style: 'single',
                info: false
            },
            columns: [
                {
                    data: 'Nome',
                    name: 'Nome'
                },
                {
                    data: 'Canal',
                    name: 'Canal'
                },
                {
                    data: 'Dados',
                    name: 'Dados'
                },
                {
                    data: 'Lote',
                    name: 'Lote'
                },
                {
                    data: 'Notificacao',
                    name: 'Notificacao'
                },
                {
                    data: 'PsCanalId',
                    name: 'PsCanalId',
                    "visible": false,
                    "searchable": false
                }
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

        tbCanalExec.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                var Lote = tbCanalExec.rows(indexes).data().pluck('Lote');
                var Notificacao = tbCanalExec.rows(indexes).data().pluck('Notificacao');
                var tbParcela = $('#tbParcela').DataTable();
                var url = "{{ route('execfila.getDadosParcelasExec') }}" + "/?lote=" + Lote[0]+"&notificacao="+Notificacao[0];
                tbParcela.ajax.url(url).load();

            }
        }).on('deselect', function (e, dt, type, indexes) {
            var tbParcela = $('#tbParcela').DataTable();
            var url = "{{ route('execfila.getDadosParcelasExec') }}" + "/?none=a";
            tbParcela.ajax.url(url).load();
        });

    }); // document ready


</script>