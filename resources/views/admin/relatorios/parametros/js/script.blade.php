<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#tbFilaConf').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('filaconf.getdata') }}",
                "data": {
                    "rel_id": '{{$Relatorio->rel_id}}'
                }
            },
            columns: [
                {
                    data: 'TABSYSNM',
                    name: 'TABSYSNM',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'REGTABNM',
                    name: 'REGTABNM'
                },
                {
                    data: 'FilaConfDs',
                    name: 'FilaConfDs'
                },
                {
                    data: 'FilaConfId',
                    name: 'FilaConfId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'TABSYSID',
                    name: 'TABSYSID',
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
            $('#pnFilaConf #btEditar').addClass('disabled');
            $('#pnFilaConf #btDeletar').addClass('disabled');
        } );

        table.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnFilaConf #btEditar').removeClass('disabled');
                $('#pnFilaConf #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnFilaConf #btEditar').addClass('disabled');
                $('#pnFilaConf #btDeletar').addClass('disabled');
            } );


        $('#formFilaConf').on('submit', function (e) {
            $.post( "{{ route('filaconf.store') }}", $( "#formFilaConf" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalFilaConf').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload();
                        $("#formFilaConf").trigger('reset');
                    }
                });
            return false;
        });
        $('#pnFilaConf #btDeletar').click(function () {
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
                        url: '{{ url('admin/filaconf/destroy') }}',
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

        $('#pnFilaConf #btEditar').click(function () {
            var linha =table.row('.selected').data();
            var rel_id = '{{$Relatorio->rel_id}}';
            var FilaConfDs = linha[   'FilaConfDs'];
            var TABSYSID = linha[   'TABSYSID'];
            var FilaConfId = linha[   'FilaConfId'];
            var id = linha['id'];
            $.ajax({
                dataType: 'json',
                type: 'GET',
                data: {
                    _token: '{!! csrf_token() !!}',
                    rel_id:rel_id,
                    FilaConfDs:FilaConfDs,
                    TABSYSID:TABSYSID,
                    FilaConfId:FilaConfId,
                    _method: 'GET'
                },
                url: '{{ url('admin/filaconf/1/edit/') }}',
                success: function (retorno) {
                    $('#pnFilaConf #formEditar #TABSYSID').val(retorno['TABSYSID']);
                    $('#pnFilaConf #formEditar #FilaConfId').val(retorno['FilaConfId']);
                    $('#pnFilaConf #formEditar #FilaConfDs').val(retorno['FilaConfDs']);
                    $('#pnFilaConf #formEditar #id').val(id);
                },
                error: function (retorno) {
                    console.log(retorno);
                }
            });
        });

        $('#pnFilaConf #formEditar').on('submit', function (e) {
            var formData = $('#pnFilaConf #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/filaconf/') }}'+'/' +$('#pnFilaConf #formEditar #id').val(),
                success: function (data) {
                    if (data){
                        $('#myModalFilaConfEdita').modal('toggle');
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
                    $('#myModalFilaConfEdita').modal('toggle');
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