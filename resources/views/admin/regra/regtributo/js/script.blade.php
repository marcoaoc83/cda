<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tableRegraTributo = $('#tbRegraTributo').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('regtributo.getdata') }}",
                "data": {
                    "RegCalcId": '{{$RegraCalculo->RegCalcId}}'
                }
            },
            columns: [
                {
                    data: 'REGTABNM',
                    name: 'REGTABNM'
                },
                {
                    data: 'id',
                    name: 'id',
                    "visible": false,
                    "searchable": false
                }
            ],
            select: {
                style: 'single',
                info: false

            },
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

        tableRegraTributo.on( 'draw', function () {
            $('#pnRegraTributo #btDeletar').addClass('disabled');
        } );

        tableRegraTributo.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnRegraTributo #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnRegraTributo #btDeletar').addClass('disabled');
            } );


        $('#formRegraTributo').on('submit', function (e) {
            $.post( "{{ route('regtributo.store') }}", $( "#formRegraTributo" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalRegraTributo').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableRegraTributo.ajax.reload();
                    }
                });
            return false;
        });
        $('#pnRegraTributo #btDeletar').click(function () {
            var linha =tableRegraTributo.row('.selected').data();
            var id = linha[   'id'];
            swal({
                title             : "Tem certeza?",
                text              : "Esta registro será deletado!",
                type              : "warning",
                showCancelButton  : true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText : "Sim",
                cancelButtonText  : "Não"
            }).then((resultado) => {
                if (resultado.value){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            _token: '{!! csrf_token() !!}',
                            'id': id,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/regtributo/destroy') }}',
                        success: function (msg) {
                            $('.datatable').DataTable().ajax.reload();
                            swal({
                                position: 'top-end',
                                type: 'success',
                                title: 'Deletado com sucesso!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        },
                        error: function (data) {
                            swal({
                                position: 'top-end',
                                type: 'error',
                                title: 'Erro ao deletar!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    });
                }
            });
        });



    });
</script>
