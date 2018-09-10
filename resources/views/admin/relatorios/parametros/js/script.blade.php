<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#tbRelParametro').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('relparametro.getdata') }}",
                "data": {
                    "rel_id": '{{$Relatorio->rel_id}}'
                }
            },
            columns: [
                {
                    data: 'rep_parametro',
                    name: 'rep_parametro'
                },
                {
                    data: 'rep_tipo',
                    name: 'rep_tipo'
                },
                {
                    data: 'rep_descricao',
                    name: 'rep_descricao'
                },
                {
                    data: 'rep_rel_id',
                    name: 'rep_rel_id',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'rep_id',
                    name: 'rep_id',
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
            $('#pnRelParametro #btEditar').addClass('disabled');
            $('#pnRelParametro #btDeletar').addClass('disabled');
        } );

        table.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnRelParametro #btEditar').removeClass('disabled');
                $('#pnRelParametro #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnRelParametro #btEditar').addClass('disabled');
                $('#pnRelParametro #btDeletar').addClass('disabled');
            } );


        $('#formRelParametro').on('submit', function (e) {
            $.post( "{{ route('relparametro.store') }}", $( "#formRelParametro" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalRelParametro').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload();
                        $("#formRelParametro").trigger('reset');
                    }
                });
            return false;
        });
        $('#pnRelParametro #btDeletar').click(function () {
            var linha =table.row('.selected').data();
            var rep_id = linha['rep_id'];
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
                            'rep_id': rep_id,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/relparametro/destroy') }}',
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

        $('#pnRelParametro #btEditar').click(function () {

            var linha =table.row('.selected').data();
            var rep_id = linha['rep_id'];

            $.ajax({
                dataType: 'json',
                type: 'GET',
                data: {
                    _token: '{!! csrf_token() !!}',
                    rep_id:rep_id,
                    _method: 'GET'
                },
                url: '{{ url('admin/relparametro/1/edit/') }}',
                success: function (retorno) {
                    $('#pnRelParametro #formEditar #rep_id').val(rep_id);
                    $('#pnRelParametro #formEditar #rep_rel_id').val(retorno['rep_rel_id']);
                    $('#pnRelParametro #formEditar #rep_parametro').val(retorno['rep_parametro']);
                    $('#pnRelParametro #formEditar #rep_descricao').val(retorno['rep_descricao']);
                    $('#pnRelParametro #formEditar #rep_tipo').val(retorno['rep_tipo']);
                    $('#pnRelParametro #formEditar #rep_valor').val(retorno['rep_valor']);
                },
                error: function (retorno) {
                    console.log(retorno);
                }
            });
        });

        $('#pnRelParametro #formEditar').on('submit', function (e) {
            var formData = $('#pnRelParametro #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/relparametro/') }}'+'/' +$('#pnRelParametro #formEditar #rep_id').val(),
                success: function (data) {
                    if (data){
                        $('#myModalRelParametroEdita').modal('toggle');
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
                    $('#myModalRelParametroEdita').modal('toggle');
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