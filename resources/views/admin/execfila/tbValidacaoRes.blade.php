<script type="text/javascript">

    $(document).ready(function() {

        var tbValidacaoRes = $('#tbValidacaoRes').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            ajax: '{{ route('execfila.getDadosValidar') }}?none=true',
            // select: {
            //     style: 'multiple',
            //     info:false
            // },
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
                    data: 'Fonte',
                    name: 'Fonte'
                },
                {
                    data: 'Evento',
                    name: 'Evento'
                },
                {
                    data: 'TipoPos',
                    name: 'TipoPos'
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

    }); // document ready


</script>