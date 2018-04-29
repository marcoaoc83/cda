<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#tbEntCart').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('entcart.getdata') }}",
                "data": {
                    "CarteiraId": '{{$Carteira->CARTEIRAID}}'
                }
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
                    data: 'EntCartId',
                    name: 'EntCartId',
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
            $('#pnEntCart #btEditar').addClass('disabled');
            $('#pnEntCart #btDeletar').addClass('disabled');
        } );

        table.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnEntCart #btEditar').removeClass('disabled');
                $('#pnEntCart #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnEntCart #btEditar').addClass('disabled');
                $('#pnEntCart #btDeletar').addClass('disabled');
            } );


        $('#formEntCart').on('submit', function (e) {
            $.post( "{{ route('entcart.store') }}", $( "#formEntCart" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalEntCart').modal('toggle');
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
        $('#pnEntCart #btDeletar').click(function () {
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
                        url: '{{ url('admin/entcart/destroy') }}',
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

        $('#pnEntCart #btEditar').click(function () {
            var linha =table.row('.selected').data();
            var CarteiraId = '{{$Carteira->CarteiraId}}';
            var AtivoSN = linha[   'AtivoSN'];
            var EntCartId = linha[   'EntCartId'];
            var id = linha['id'];
            $.ajax({
                dataType: 'json',
                type: 'GET',
                data: {
                    _token: '{!! csrf_token() !!}',
                    CarteiraId:CarteiraId,
                    EntCartId:EntCartId,
                    AtivoSN:AtivoSN,
                    _method: 'GET'
                },
                url: '{{ url('admin/entcart/1/edit/') }}',
                success: function (retorno) {
                    $('#pnEntCart #formEditar #EntCartId').val(retorno['EntCartId']);
                    var ativo=false;
                    if(retorno['AtivoSN']==1) ativo=true;

                    if($( '#pnEntCart #formEditar #AtivoSN' ).prop("checked") !=ativo){
                        $( '#pnEntCart #formEditar #AtivoSN' ).trigger("click");
                    }

                    $('#pnEntCart #formEditar #id').val(id);
                },
                error: function (retorno) {
                    console.log(retorno);
                }
            });
        });

        $('#pnEntCart #formEditar').on('submit', function (e) {
            var formData = $('#pnEntCart #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/entcart/') }}'+'/' +$('#pnEntCart #formEditar #id').val(),
                success: function (data) {
                    if (data){
                        $('#myModalEntCartEdita').modal('toggle');
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
                    $('#myModalEntCartEdita').modal('toggle');
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
