<script type="text/javascript">

    $(document).ready(function() {


        var tbCarteira = $('#tbCarteira').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "searching": false,
            "paging":   false,
            "ordering": false,
            "info":     false,

            ajax: '{{ route('carteira.getdataCarteira') }}',
            select: {
                style: 'single',
                info:false
            },
            columns: [
                {
                    data:null,
                    name:"check",
                    searchable: false,
                    orderable: false,
                    width: '1%',
                    className: 'col-lg-1 col-centered',
                    render: function (data, type, full, meta) {

                        return '<input type="checkbox" name="CARTEIRAID[]" value="'+data.CARTEIRAID+'">';
                    },
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).prop("scope", "row");
                    }
                },
                {data: 'CARTEIRAORD', name: 'CARTEIRAORD'},
                {data: 'CARTEIRASG', name: 'CARTEIRASG'},
                {
                    data: 'CARTEIRAID',
                    name: 'CARTEIRAID',
                    "visible": false,
                    "searchable": false
                },
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

        tbCarteira.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var CARTEIRAID = tbCarteira.rows( indexes ).data().pluck( 'CARTEIRAID' );
                var tableRoteiro = $('#tbRoteiro').DataTable();
                var url = "{{ route('execfila.getDadosRoteiro') }}"+"/?CARTEIRAID="+CARTEIRAID[0];
                tableRoteiro.ajax.url(url).load();
            }
        }).on( 'deselect', function ( e, dt, type, indexes ){
            var tableRoteiro = $('#tbRoteiro').DataTable();
            var url = "{{ route('execfila.getDadosRoteiro') }}"+"/?CARTEIRAID=a";
            tableRoteiro.ajax.url(url).load();
        });
    }); // document ready


</script>