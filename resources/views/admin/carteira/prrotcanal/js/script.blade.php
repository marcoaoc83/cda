<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tablePrRotCanal = $('#tbPrRotCanal').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            destroy: true,
            ajax: {
                "url": "{{ route('prrotcanal.getdata') }}"
            },
            columns: [


                {
                    data: 'PrioridadeNr',
                    name: 'PrioridadeNr'
                },
                {
                    data: 'REGTABNM',
                    name: 'REGTABNM'
                },
                {
                    data: 'TpPosId',
                    name: 'TpPosId',
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

        tablePrRotCanal.on( 'draw', function () {
            $('#pnPrRotCanal #btEditar').addClass('disabled');
            $('#pnPrRotCanal #btDeletar').addClass('disabled');
        } );

        tablePrRotCanal.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnPrRotCanal #btEditar').removeClass('disabled');
                $('#pnPrRotCanal #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnPrRotCanal #btEditar').addClass('disabled');
                $('#pnPrRotCanal #btDeletar').addClass('disabled');
            } );


        $('#formPrRotCanal').on('submit', function (e) {
            $.post( "{{ route('prrotcanal.store') }}", $( "#formPrRotCanal" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalPrRotCanal').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tablePrRotCanal.ajax.reload();
                    }
                });
            return false;
        });
        $('#pnPrRotCanal #btDeletar').click(function () {
            var linha =tablePrRotCanal.row('.selected').data();
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
                        url: '{{ url('admin/prrotcanal/destroy') }}',
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

        $('#pnPrRotCanal #btEditar').click(function () {
            var linha =tablePrRotCanal.row('.selected').data();
            var CarteiraId = '{{$Carteira->CarteiraId}}';
            var PrioridadeNr = linha[   'PrioridadeNr'];
            var TpPosId = linha[   'TpPosId'];
            var id = linha['id'];
            $.ajax({
                dataType: 'json',
                type: 'GET',
                data: {
                    _token: '{!! csrf_token() !!}',
                    CarteiraId:CarteiraId,
                    TpPosId:TpPosId,
                    PrioridadeNr:PrioridadeNr,
                    _method: 'GET'
                },
                url: '{{ url('admin/prrotcanal/1/edit/') }}',
                success: function (retorno) {
                    $('#pnPrRotCanal #formEditar #PrioridadeNr').val(retorno['PrioridadeNr']);
                    $('#pnPrRotCanal #formEditar #TpPosId').val(retorno['TpPosId']);
                    $('#pnPrRotCanal #formEditar #id').val(id);
                },
                error: function (retorno) {
                    console.log(retorno);
                }
            });
        });

        $('#pnPrRotCanal #formEditar').on('submit', function (e) {
            var formData = $('#pnPrRotCanal #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/prrotcanal/') }}'+'/' +$('#pnPrRotCanal #formEditar #id').val(),
                success: function (data) {
                    if (data){
                        $('#myModalPrRotCanalEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tablePrRotCanal.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalPrRotCanalEdita').modal('toggle');
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
