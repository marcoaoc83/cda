<script type="text/javascript">

    $(document).ready(function() {


        var tbValidacao = $('#tbValidacao').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            ajax: '{{ route('execfila.getDadosValidacao') }}',
            select: {
                style: 'multiple',
                info:false
            },
            columns: [
                {
                    data: 'REGTABSG',
                    name: 'REGTABSG'
                },
                {
                    data: 'REGTABNM',
                    name: 'REGTABNM'
                },
                {
                    data: 'EventoSg',
                    name: 'EventoSg'
                },
                {
                    data: 'EventoId',
                    name: 'EventoId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'ValEnvId',
                    name: 'ValEnvId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'id',
                    name: 'id',
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