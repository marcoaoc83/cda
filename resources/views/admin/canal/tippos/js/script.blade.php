<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#tbTipPos').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('tippos.getdata') }}",
                "data": {
                    "CANALID": '{{$canal->CANALID}}'
                }
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
                    data: 'TipPosId',
                    name: 'TipPosId',
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
            $('#pnTipPos #btEditar').addClass('disabled');
            $('#pnTipPos #btDeletar').addClass('disabled');
        } );

        table.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnTipPos #btEditar').removeClass('disabled');
                $('#pnTipPos #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnTipPos #btEditar').addClass('disabled');
                $('#pnTipPos #btDeletar').addClass('disabled');
            } );


        $('#formTipPos').on('submit', function (e) {
            $.post( "{{ route('tippos.store') }}", $( "#formTipPos" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalTipPos').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload();
                        $("#formTipPos").trigger('reset');
                    }
                });
            return false;
        });
        $('#pnTipPos #btDeletar').click(function () {
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
                        url: '{{ url('admin/tippos/destroy') }}',
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

        $('#pnTipPos #btEditar').click(function () {
            var linha =table.row('.selected').data();
            var CanalId = '{{$canal->CANALID}}';
            var TipPosId = linha[   'TipPosId'];
            var id = linha['id'];
            $.ajax({
                dataType: 'json',
                type: 'GET',
                data: {
                    _token: '{!! csrf_token() !!}',
                    CanalId:CanalId,
                    TipPosId:TipPosId,
                    _method: 'GET'
                },
                url: '{{ url('admin/tippos/1/edit/') }}',
                success: function (retorno) {
                    $('#pnTipPos #formEditar #TipPosId').val(retorno['TipPosId']);
                    $('#pnTipPos #formEditar #EventoId').val(retorno['EventoId']);
                    $('#pnTipPos #formEditar #id').val(id);
                },
                error: function (retorno) {
                    console.log(retorno);
                }
            });
        });

        $('#pnTipPos #formEditar').on('submit', function (e) {
            var formData = $('#pnTipPos #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/tippos/') }}'+'/' +$('#pnTipPos #formEditar #id').val(),
                success: function (data) {
                    if (data){
                        $('#myModalTipPosEdita').modal('toggle');
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
                    $('#myModalTipPosEdita').modal('toggle');
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