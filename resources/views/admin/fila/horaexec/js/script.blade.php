<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#tbHoraExec').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('horaexec.getdata') }}",
                "data": {
                    "FilaTrabId": '{{$Fila->FilaTrabId}}'
                }
            },
            columns: [


                {
                    data: 'REGTABNM',
                    name: 'REGTABNM'
                },
                {
                    data: 'HInicial',
                    name: 'HInicial'
                },
                {
                    data: 'HFinal',
                    name: 'HFinal'
                },
                {
                    data: 'DiaSemId',
                    name: 'DiaSemId',
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
            select: {
                style: 'single',
                info: false

            },
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

        table.on( 'draw', function () {
            $('#pnHoraExec #btEditar').addClass('disabled');
            $('#pnHoraExec #btDeletar').addClass('disabled');
        } );

        table.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnHoraExec #btEditar').removeClass('disabled');
                $('#pnHoraExec #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnHoraExec #btEditar').addClass('disabled');
                $('#pnHoraExec #btDeletar').addClass('disabled');
            } );


        $('#formHoraExec').on('submit', function (e) {
            $.post( "{{ route('horaexec.store') }}", $( "#formHoraExec" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalHoraExec').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload();
                    }
                });
            return false;
        });
        $('#pnHoraExec #btDeletar').click(function () {
            var linha =table.row('.selected').data();
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
                        url: '{{ url('admin/horaexec/destroy') }}',
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

        $('#pnHoraExec #btEditar').click(function () {
            var linha =table.row('.selected').data();
            var FilaTrabId = '{{$Fila->FilaTrabId}}';
            var HInicial = linha[   'HInicial'];
            var HFinal = linha[   'HFinal'];
            var DiaSemId = linha[   'DiaSemId'];
            var id = linha['id'];
            $.ajax({
                dataType: 'json',
                type: 'GET',
                data: {
                    _token: '{!! csrf_token() !!}',
                    FilaTrabId:FilaTrabId,
                    DiaSemId:DiaSemId,
                    HInicial:HInicial,
                    HFinal:HFinal,
                    _method: 'GET'
                },
                url: '{{ url('admin/horaexec/1/edit/') }}',
                success: function (retorno) {
                    $('#pnHoraExec #formEditar #DiaSemId').val(retorno['DiaSemId']);
                    $('#pnHoraExec #formEditar #HInicial').val(retorno['HInicial']);
                    $('#pnHoraExec #formEditar #HFinal').val(retorno['HFinal']);
                    $('#pnHoraExec #formEditar #id').val(id);
                },
                error: function (retorno) {
                    console.log(retorno);
                }
            });
        });

        $('#pnHoraExec #formEditar').on('submit', function (e) {
            var formData = $('#pnHoraExec #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/horaexec/') }}'+'/' +$('#pnHoraExec #formEditar #id').val(),
                success: function (data) {
                    if (data){
                        $('#myModalHoraExecEdita').modal('toggle');
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
                    $('#myModalHoraExecEdita').modal('toggle');
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.js"></script>
<script>
    $("#HInicial").inputmask({
        mask: ['99:99'],
        keepStatic: true
    });
    $("#HFinal").inputmask({
        mask: ['99:99'],
        keepStatic: true
    });
</script>