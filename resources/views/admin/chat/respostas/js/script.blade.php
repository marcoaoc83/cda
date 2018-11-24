<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#tbRespostas').DataTable({
            processing: true,
            serverSresp_ide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('chatrespostas.getdata') }}",
                "data": {
                    "resp_intents_slug": '{{$Chat->slug}}'
                }
            },
            columns: [

                {
                    data: 'resp_texto',
                    name: 'resp_texto'
                },
                {
                    data: 'resp_id',
                    name: 'resp_id',
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

        table.on( 'draw', function () {
            $('#pnRespostas #btEditar').addClass('disabled');
            $('#pnRespostas #btDeletar').addClass('disabled');
        } );

        table.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnRespostas #btEditar').removeClass('disabled');
                $('#pnRespostas #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnRespostas #btEditar').addClass('disabled');
                $('#pnRespostas #btDeletar').addClass('disabled');
            } );


        $('#formRespostas').on('submit', function (e) {
            $.post( "{{ route('chatrespostas.store') }}", $( "#formRespostas" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalRespostas').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload();
                        $("#formRespostas").trigger('reset');
                    }
                });
            return false;
        });
        $('#pnRespostas #btDeletar').click(function () {
            var linha =table.row('.selected').data();
            var resp_id = linha[   'resp_id'];
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
                            'resp_id': resp_id,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/chatrespostas/destroy') }}',
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

        $('#pnRespostas #btEditar').click(function () {
            var linha =table.row('.selected').data();
            var resp_texto = linha[   'resp_texto'];
            var resp_id = linha['resp_id'];
            $('#pnRespostas #formEditar #resp_texto').val(resp_texto);
            $('#pnRespostas #formEditar #resp_intents_slug').val('{{$Chat->slug}}');
            $('#pnRespostas #formEditar #resp_id').val(resp_id);
        });

        $('#pnRespostas #formEditar').on('submit', function (e) {
            var formData = $('#pnRespostas #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/chatrespostas/') }}'+'/' +$('#pnRespostas #formEditar #resp_id').val(),
                success: function (data) {
                    if (data){
                        $('#myModalRespostasEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalRespostasEdita').modal('toggle');
                    console.log(retorno.responseJSON.message);
                    swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Erro!',
                        text: retorno.responseJSON.message,
                        showConfirmButton: false,
                        timer: 7500
                    });

                }
            });

            return false;
        });


    });
</script>