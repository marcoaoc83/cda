<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tbPerguntas = $('#tbPerguntas').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            destroy: true,
            ajax: {
                "url": "{{ route('chatperguntas.getdata') }}?id={!! $Chat->slug !!}"
            },
            columns: [


                {
                    data: 'source',
                    name: 'source'
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
        tbPerguntas.on( 'draw', function () {
            $('#pnPerguntas #btEditar').addClass('disabled');
            $('#pnPerguntas #btDeletar').addClass('disabled');
        } );

        tbPerguntas.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnPerguntas #btEditar').removeClass('disabled');
                $('#pnPerguntas #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnPerguntas #btEditar').addClass('disabled');
                $('#pnPerguntas #btDeletar').addClass('disabled');
            } );



        $('#formPerguntas').on('submit', function (e) {
            $.post( "{{ route('chatperguntas.store') }}", $( "#formPerguntas" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalPerguntas').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tbPerguntas.ajax.reload();
                    }
                });
            return false;
        });

        $('#pnPerguntas #btEditar').click(function () {
            var linha =tbPerguntas.row('.selected').data();
            var intent = '{{$Chat->slug}}';
            var source = linha[   'source'];
            var id = linha['id'];
            $('#pnPerguntas #formEditar #intent').val(intent);
            $('#pnPerguntas #formEditar #source').val(source);
            $('#pnPerguntas #formEditar #id').val(id);
        });

        $('#pnPerguntas #formEditar').on('submit', function (e) {
            var formData = $('#pnPerguntas #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/chatperguntas/') }}'+'/' +$('#pnPerguntas #formEditar #id').val(),
                success: function (data) {
                    if (data){
                        $('#myModalPerguntasEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tbPerguntas.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalPerguntasEdita').modal('toggle');
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

        $('#pnPerguntas #btDeletar').click(function () {
            var linha =tbPerguntas.row('.selected').data();
            var id = linha['id'];
            var intent = '{{$Chat->slug}}';
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
                            'intent': intent,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/chatperguntas/destroy') }}',
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
