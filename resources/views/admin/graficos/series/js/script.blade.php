<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tableSeries = $('#tbSeries').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('graficosseries.getdata') }}",
                "data": {
                    "grse_grafico_id": '{{$Graficos->graf_id}}'
                }
            },
            columns: [
                {
                    data: 'grse_titulo',
                    name: 'grse_titulo'
                },
                {
                    data: 'grse_id',
                    name: 'grse_id',
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

        tableSeries.on( 'draw', function () {
            $('#pnSeries #btEditar').addClass('disabled');
            $('#pnSeries #btDeletar').addClass('disabled');
        } );

        tableSeries.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnSeries #btEditar').removeClass('disabled');
                $('#pnSeries #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnSeries #btEditar').addClass('disabled');
                $('#pnSeries #btDeletar').addClass('disabled');
            } );


        $('#formSeries').on('submit', function (e) {
            $.post( "{{ route('graficosseries.store') }}", $( "#formSeries" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalSeries').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableSeries.ajax.reload();
                        $('#formSeries').trigger("reset");
                    }
                });
            return false;
        });
        $('#pnSeries #btDeletar').click(function () {
            var linha =tableSeries.row('.selected').data();
            var id = linha[   'grse_id'];
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
                        url: '{{ url('admin/graficosseries/destroy') }}',
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

        $('#pnSeries #btEditar').click(function () {
            var linha =tableSeries.row('.selected').data();
            var grse_id = linha['grse_id'];
            $.ajax({
                dataType: 'json',
                type: 'GET',
                data: {
                    _token: '{!! csrf_token() !!}',
                    grse_id:grse_id,
                    _method: 'GET'
                },
                url: '{{ url('admin/graficosseries/1/edit/') }}',
                success: function (retorno) {
                    $('#pnSeries #formEditar #grse_tipo').val(retorno['grse_tipo']);
                    $('#pnSeries #formEditar #grse_titulo').val(retorno['grse_titulo']);
                    $('#pnSeries #formEditar #grse_subtitulo').val(retorno['grse_subtitulo']);
                    $('#pnSeries #formEditar #grse_sql_valor').val(retorno['grse_sql_valor']);
                    $('#pnSeries #formEditar #grse_sql_campo').val(retorno['grse_sql_campo']);
                    $('#pnSeries #formEditar #grse_sql_condicao').val(retorno['grse_sql_condicao']);
                    $('#pnSeries #formEditar #grse_sql_agrupamento').val(retorno['grse_sql_agrupamento']);
                    //$('#pnSeries #formEditar #grse_sql_ordenacao').val(retorno['grse_sql_ordenacao']);
                    $('#pnSeries #formEditar #grse_eixoy').val(retorno['grse_eixoy']);
                    $('#pnSeries #formEditar #grse_id').val(grse_id);
                },
                error: function (retorno) {
                    console.log(retorno);
                }
            });
        });

        $('#pnSeries #formEditar').on('submit', function (e) {
            var formData = $('#pnSeries #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/graficosseries/') }}'+'/' +$('#pnSeries #formEditar #grse_id').val(),
                success: function (data) {
                    if (data){
                        $('#myModalSeriesEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableSeries.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalSeriesEdita').modal('toggle');
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
