<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#tbExpArquivo').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('exparquivo.getdata') }}",
                "data": {
                    "exp_id": '{{$ExpLayout->exp_id}}'
                }
            },
            columns: [
                {
                    data: 'ext_nome',
                    name: 'ext_nome'
                },
                {
                    data: 'ext_tabela',
                    name: 'ext_tabela'
                },


                {
                    data: 'ext_layout_id',
                    name: 'ext_layout_id',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'ext_id',
                    name: 'ext_id',
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
            $('#pnExpArquivo #btEditar').addClass('disabled');
            $('#pnExpArquivo #btDeletar').addClass('disabled');
        } );

        table.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnExpArquivo #btEditar').removeClass('disabled');
                $('#pnExpArquivo #btDeletar').removeClass('disabled');


                var ARQUIVO = table.rows( indexes ).data().pluck( 'ext_id' );
                var TABELA = table.rows( indexes ).data().pluck( 'ext_tabela' );
                var tbExpCampo = $('#tbExpCampo').DataTable();
                var url = "{{ route('expcampo.getdata') }}"+"/?exc_tabela="+ARQUIVO[0];
                tbExpCampo.ajax.url(url).load( );
                $('#formExpCampo #exc_tabela').val(ARQUIVO[0]);
                $('#formExpCampo #tabela').val(TABELA[0]);
                $('#myModalExpCampoEdita #exc_tabela').val(ARQUIVO[0]);
                $('#myModalExpCampoEdita #tabela').val(TABELA[0]);
                $('#pnExpCampo #btInserir').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnExpArquivo #btEditar').addClass('disabled');
                $('#pnExpArquivo #btDeletar').addClass('disabled');
                $('#pnExpCampo #btInserir').addClass('disabled');
            } );


        $('#formExpArquivo').on('submit', function (e) {
            $.post( "{{ route('exparquivo.store') }}", $( "#formExpArquivo" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalExpArquivo').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload();
                        $("#formExpArquivo").trigger('reset');
                    }
                });
            return false;
        });
        $('#pnExpArquivo #btDeletar').click(function () {
            var linha =table.row('.selected').data();
            var id = linha[   'ext_id'];
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
                            'exc_id': id,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/exparquivo/destroy') }}',
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

        $('#pnExpArquivo #btEditar').click(function () {
            var linha =table.row('.selected').data();

            var exp_tabela = '{{$ExpLayout->exp_tabela}}';
            var exc_ord = linha['exc_ord'];
            var exc_campo = linha['exc_campo'];
            var exc_titulo = linha['exc_titulo'];

            var exc_id = linha['exc_id'];
            $('#pnExpArquivo #formEditar #exc_id').val(exc_id);
            $('#pnExpArquivo #formEditar #exc_ord').val(exc_ord);
            $('#pnExpArquivo #formEditar #exc_campo').val(exc_campo);
            $('#pnExpArquivo #formEditar #exc_titulo').val(exc_titulo);
            reloadCampo('#myModalExpArquivoEdita #exc_campo',exp_tabela,exc_campo);

        });

        $('#pnExpArquivo #formEditar').on('submit', function (e) {
            var formData = $('#pnExpArquivo #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/exparquivo/') }}'+'/' +$('#pnExpArquivo #formEditar #exc_id').val(),
                success: function (data) {
                    if (data){
                        $('#myModalExpArquivoEdita').modal('toggle');
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
                    $('#myModalExpArquivoEdita').modal('toggle');
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