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
            ajax: '{{ route('carteira.getdataRoteiro') }}',

            columns: [
                {
                    data:null,
                    name:"check",
                    searchable: false,
                    orderable: false,
                    width: '1%',
                    className: 'col-lg-1 col-centered',
                    render: function (data, type, full, meta) {
                        if ( $( "#roteirosId"+data.RoteiroId ).length ) {
                            return '<input type="checkbox" name="roteiros[]" checked value="' + data.RoteiroId + '" onchange="addRoteiro(this)">';
                        }else{
                            return '<input type="checkbox" name="roteiros[]" value="' + data.RoteiroId + '" onchange="addRoteiro(this)">';
                        }
                    },
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).prop("scope", "row");
                    }
                },
                {data: 'RoteiroOrd', name: 'RoteiroOrd'},
                {data: 'FaseCartNM', name: 'FaseCartNM'},
                {data: 'EventoNM', name: 'EventoNM'},
                {data: 'ModComNM', name: 'ModComNM'},
                {data: 'FilaTrabNM', name: 'FilaTrabNM'},
                {data: 'CanalNM', name: 'CanalNM'},
                {
                    data: 'RoteiroId',
                    name: 'RoteiroId',
                    "visible": false,
                    "searchable": false
                },
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });


    }); // document ready


</script>