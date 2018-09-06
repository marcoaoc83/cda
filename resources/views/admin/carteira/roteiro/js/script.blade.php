<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tableRoteiro = $('#tbRoteiro').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('roteiro.getdata') }}",
                "data": {
                    "CarteiraId": '{{$Carteira->CARTEIRAID}}'
                }
            },
            columns: [

                {
                    data: 'RoteiroOrd',
                    name: 'RoteiroOrd'
                },

                {
                    data: 'FaseCartNM',
                    name: 'FaseCartNM'
                },

                {
                    data: 'EventoNM',
                    name: 'EventoNM'
                },

                {
                    data: 'ModComNM',
                    name: 'ModComNM'
                },

                {
                    data: 'FilaTrabNM',
                    name: 'FilaTrabNM'
                },

                {
                    data: 'CanalNM',
                    name: 'CanalNM'
                },

                {
                    data: 'RoteiroProxNM',
                    name: 'RoteiroProxNM'
                },
                {
                    data: 'FaseCartId',
                    name: 'FaseCartId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'EventoId',
                    name: 'EventoId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'ModComId',
                    name: 'ModComId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'FilaTrabId',
                    name: 'FilaTrabId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'CanalId',
                    name: 'CanalId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'RoteiroProxId',
                    name: 'RoteiroProxId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'RoteiroId',
                    name: 'RoteiroId',
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

        tableRoteiro.on( 'draw', function () {
            $('#pnRoteiro #btEditar').addClass('disabled');
            $('#pnRoteiro #btDeletar').addClass('disabled');
        } );

        tableRoteiro.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnRoteiro #btEditar').removeClass('disabled');
                $('#pnRoteiro #btDeletar').removeClass('disabled');

                var RoteiroId = tableRoteiro.rows( indexes ).data().pluck( 'RoteiroId' );

                var tableExecRot = $('#tbExecRot').DataTable();
                var url = "{{ route('execrot.getdata') }}"+"/?RoteiroId="+RoteiroId[0];
                tableExecRot.ajax.url(url).load( );

                var tablePrRotCanal = $('#tbPrRotCanal').DataTable();
                var url = "{{ route('prrotcanal.getdata') }}"+"/?RoteiroId="+RoteiroId[0];
                tablePrRotCanal.ajax.url(url).load( );

                $('#formExecRot #RoteiroId').val(RoteiroId[0]);
                $('#myModalExecRotEdita #RoteiroId').val(RoteiroId[0]);
                $('#pnExecRot #btInserir').removeClass('disabled');

                $('#formPrRotCanal #RoteiroId').val(RoteiroId[0]);
                $('#myPrRotCanal #RoteiroId').val(RoteiroId[0]);
                $('#pnPrRotCanal #btInserir').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnRoteiro #btEditar').addClass('disabled');
                $('#pnRoteiro #btDeletar').addClass('disabled');
                $('#pnExecRot #btInserir').addClass('disabled');
                $('#pnPrRotCanal #btInserir').addClass('disabled');
            } );


        $('#formRoteiro').on('submit', function (e) {
            $.post( "{{ route('roteiro.store') }}", $( "#formRoteiro" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalRoteiro').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableRoteiro.ajax.reload();
                    }
                });
            return false;
        });
        $('#pnRoteiro #btDeletar').click(function () {
            var linha =tableRoteiro.row('.selected').data();
            var id = linha[   'RoteiroId'];
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
                        url: '{{ url('admin/roteiro/destroy') }}',
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

        $('#pnRoteiro #btEditar').click(function () {
            var linha =tableRoteiro.row('.selected').data();
            var RoteiroOrd = linha[   'RoteiroOrd'];
            var FaseCartId = linha[   'FaseCartId'];
            var EventoId = linha[   'EventoId'];
            var ModComId = linha[   'ModComId'];
            var FilaTrabId = linha[   'FilaTrabId'];
            var CanalId = linha[   'CanalId'];
            var RoteiroProxId = linha[   'RoteiroProxId'];
            var RoteiroId = linha['RoteiroId'];
            $.ajax({
                dataType: 'json',
                type: 'GET',
                data: {
                    _token: '{!! csrf_token() !!}',
                    RoteiroId:RoteiroId,
                    RoteiroOrd:RoteiroOrd,
                    FaseCartId:FaseCartId,
                    EventoId:EventoId,
                    ModComId:ModComId,
                    FilaTrabId:FilaTrabId,
                    CanalId:CanalId,
                    RoteiroProxId:RoteiroProxId,
                    _method: 'GET'
                },
                url: '{{ url('admin/roteiro/1/edit/') }}',
                success: function (retorno) {
                    $('#pnRoteiro #formEditar #RoteiroOrd').val(retorno['RoteiroOrd']);
                    $('#pnRoteiro #formEditar #FaseCartId').val(retorno['FaseCartId']);
                    $('#pnRoteiro #formEditar #EventoId').val(retorno['EventoId']);
                    $('#pnRoteiro #formEditar #ModComId').val(retorno['ModComId']);
                    $('#pnRoteiro #formEditar #FilaTrabId').val(retorno['FilaTrabId']);
                    $('#pnRoteiro #formEditar #CanalId').val(retorno['CanalId']);
                    $('#pnRoteiro #formEditar #RoteiroProxId').val(retorno['RoteiroProxId']);
                    $('#pnRoteiro #formEditar #RoteiroId').val(RoteiroId);
                },
                error: function (retorno) {
                    console.log(retorno);
                }
            });
        });

        $('#pnRoteiro #formEditar').on('submit', function (e) {
            var formData = $('#pnRoteiro #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/roteiro/') }}'+'/' +$('#pnRoteiro #formEditar #RoteiroId').val(),
                success: function (data) {
                    if (data){
                        $('#myModalRoteiroEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableRoteiro.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalRoteiroEdita').modal('toggle');
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
