<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tbRoteiro = $('#tbRoteiro').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,
            ajax: '{{ route('execfila.getDadosRoteiro') }}'+'?CARTEIRAID=a&fila={!! $Fila->FilaTrabId !!}',
            select: {
                style: 'single',
                info:false
            },
            columns: [

                {
                    data: 'RoteiroOrd',
                    name: 'RoteiroOrd'
                },

                {
                    data: 'FaseCartNM',
                    name: 'FaseCartNM'
                },

                {
                    data: 'EventoNM',
                    name: 'EventoNM'
                },

                {
                    data: 'ModComNM',
                    name: 'ModComNM'
                },

                {
                    data: 'FilaTrabNM',
                    name: 'FilaTrabNM'
                },

                {
                    data: 'CanalNM',
                    name: 'CanalNM'
                },

                {
                    data: 'RoteiroProxNM',
                    name: 'RoteiroProxNM'
                },
                {
                    data: 'FaseCartId',
                    name: 'FaseCartId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'EventoId',
                    name: 'EventoId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'ModComId',
                    name: 'ModComId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'FilaTrabId',
                    name: 'FilaTrabId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'CanalId',
                    name: 'CanalId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'RoteiroProxId',
                    name: 'RoteiroProxId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'RoteiroId',
                    name: 'RoteiroId',
                    "visible": false,
                    "searchable": false
                }
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });


    });
</script>
