<script type="text/javascript">

    $(document).ready(function() {

        var tbCanalRes = $('#tbCanalRes').DataTable({
            processing: false,
            serverSide: false,
            responsive: true,
            "searching": false,
            "paging":   true,
            "ordering": false,
            "info":     true,
            ajax: '{{ route('execfila.getDadosValidarAll') }}?none=true',
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
                {data: 'action', name: 'action',"visible": false, orderable: false, searchable: false},
                {data: 'action2', name: 'action3',"visible": false, orderable: false, searchable: false},
                {data: 'action3', name: 'action3',"visible": false, orderable: false, searchable: false},
                {
                    data: 'PsCanalId',
                    name: 'PsCanalId',
                    "visible": false,
                    "searchable": false
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