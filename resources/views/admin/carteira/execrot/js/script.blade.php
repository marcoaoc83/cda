<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tableExecRot = $('#tbExecRot').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            destroy: true,
            ajax: {
                "url": "{{ route('execrot.getdata') }}"
            },
            columns: [


                {
                    data: 'REGTABNM',
                    name: 'REGTABNM'
                },
                {
                    data: 'AtivoSN',
                    name: 'AtivoSN',
                    render: function ( data, type, row ) {
                        if(data==1){
                            return "Sim";
                        }else{
                            return "Não";
                        }
                    }
                },
                {
                    data: 'ExecRotId',
                    name: 'ExecRotId',
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

        tableExecRot.on( 'draw', function () {
            $('#pnExecRot #btEditar').addClass('disabled');
            $('#pnExecRot #btDeletar').addClass('disabled');
        } );

        tableExecRot.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnExecRot #btEditar').removeClass('disabled');
                $('#pnExecRot #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnExecRot #btEditar').addClass('disabled');
                $('#pnExecRot #btDeletar').addClass('disabled');
            } );


        $('#formExecRot').on('submit', function (e) {
            $.post( "{{ route('execrot.store') }}", $( "#formExecRot" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalExecRot').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableExecRot.ajax.reload();
                    }
                });
            return false;
        });
        $('#pnExecRot #btDeletar').click(function () {
            var linha =tableExecRot.row('.selected').data();
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
                        url: '{{ url('admin/execrot/destroy') }}',
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

        $('#pnExecRot #btEditar').click(function () {
            var linha =tableExecRot.row('.selected').data();
            var CarteiraId = '{{$Carteira->CarteiraId}}';
            var AtivoSN = linha[   'AtivoSN'];
            var ExecRotId = linha[   'ExecRotId'];
            var id = linha['id'];
            $.ajax({
                dataType: 'json',
                type: 'GET',
                data: {
                    _token: '{!! csrf_token() !!}',
                    CarteiraId:CarteiraId,
                    ExecRotId:ExecRotId,
                    AtivoSN:AtivoSN,
                    _method: 'GET'
                },
                url: '{{ url('admin/execrot/1/edit/') }}',
                success: function (retorno) {
                    $('#pnExecRot #formEditar #ExecRotId').val(retorno['ExecRotId']);
                    var ativo=false;
                    if(retorno['AtivoSN']==1) ativo=true;

                    if($( '#pnExecRot #formEditar #AtivoSN' ).prop("checked") !=ativo){
                        $( '#pnExecRot #formEditar #AtivoSN' ).trigger("click");
                    }

                    $('#pnExecRot #formEditar #id').val(id);
                },
                error: function (retorno) {
                    console.log(retorno);
                }
            });
        });

        $('#pnExecRot #formEditar').on('submit', function (e) {
            var formData = $('#pnExecRot #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/execrot/') }}'+'/' +$('#pnExecRot #formEditar #id').val(),
                success: function (data) {
                    if (data){
                        $('#myModalExecRotEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableExecRot.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalExecRotEdita').modal('toggle');
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
