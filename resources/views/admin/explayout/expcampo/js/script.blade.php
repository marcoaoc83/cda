<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#tbExpCampo').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('expcampo.getdata') }}",
                "data": {
                    "exp_id": '{{$ExpLayout->exp_id}}'
                }
            },
            columns: [

                {
                    data: 'exc_ord',
                    name: 'exc_ord'
                },
                {
                    data: 'exc_titulo',
                    name: 'exc_titulo'
                },
                {
                    data: 'exc_campo',
                    name: 'exc_campo'
                },


                {
                    data: 'exc_layout_id',
                    name: 'exc_layout_id',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'exc_id',
                    name: 'exc_id',
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
            $('#pnExpCampo #btEditar').addClass('disabled');
            $('#pnExpCampo #btDeletar').addClass('disabled');
        } );

        table.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnExpCampo #btEditar').removeClass('disabled');
                $('#pnExpCampo #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnExpCampo #btEditar').addClass('disabled');
                $('#pnExpCampo #btDeletar').addClass('disabled');
            } );


        $('#formExpCampo').on('submit', function (e) {
            $.post( "{{ route('expcampo.store') }}", $( "#formExpCampo" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalExpCampo').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload();
                        $("#formExpCampo").trigger('reset');
                    }
                });
            return false;
        });
        $('#pnExpCampo #btDeletar').click(function () {
            var linha =table.row('.selected').data();
            var id = linha[   'exc_id'];
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
                        url: '{{ url('admin/expcampo/destroy') }}',
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

        $('#pnExpCampo #btEditar').click(function () {
            var linha =table.row('.selected').data();

            var exp_tabela = '{{$ExpLayout->exp_tabela}}';
            var exc_ord = linha[   'exc_ord'];
            var exc_campo = linha[   'exc_campo'];
            var exc_titulo = linha[   'exc_titulo'];

            var exc_id = linha['exc_id'];
            $('#pnExpCampo #formEditar #exc_id').val(exc_id);
            $('#pnExpCampo #formEditar #exc_ord').val(exc_ord);
            $('#pnExpCampo #formEditar #exc_campo').val(exc_campo);
            $('#pnExpCampo #formEditar #exc_titulo').val(exc_titulo);
            reloadCampo('#myModalExpCampoEdita #exc_campo',exp_tabela,exc_campo);

        });

        $('#pnExpCampo #formEditar').on('submit', function (e) {
            var formData = $('#pnExpCampo #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/expcampo/') }}'+'/' +$('#pnExpCampo #formEditar #exc_id').val(),
                success: function (data) {
                    if (data){
                        $('#myModalExpCampoEdita').modal('toggle');
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
                    $('#myModalExpCampoEdita').modal('toggle');
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