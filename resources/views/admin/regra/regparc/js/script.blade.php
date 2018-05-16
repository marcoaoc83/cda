<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tableRegParc = $('#tbRegParc').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('regparc.getdata') }}",
                "data": {
                    "RegCalcId": '{{$RegraCalculo->RegCalcId}}'
                }
            },
            columns: [

                {
                    data: 'ParcelaQt',
                    name: 'ParcelaQt'
                },

                {
                    data: 'REGTABNM',
                    name: 'REGTABNM'
                },

                {
                    data: 'FatorVr',
                    name: 'FatorVr'
                },

                {
                    data: 'JuroDescTx',
                    name: 'JuroDescTx'
                },

                {
                    data: 'MultaDescTx',
                    name: 'MultaDescTx'
                },

                {
                    data: 'PrincipalDescTx',
                    name: 'PrincipalDescTx'
                },

                {
                    data: 'EntradaMinVr',
                    name: 'EntradaMinVr'
                },

                {
                    data: 'ParcelaMinVr',
                    name: 'ParcelaMinVr'
                },
                {
                    data: 'OpRegId',
                    name: 'OpRegId',
                    "visible": false,
                    "searchable": false
                },

                {
                    data: 'RegParcId',
                    name: 'RegParcId',
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

        tableRegParc.on( 'draw', function () {
            $('#pnRegParc #btEditar').addClass('disabled');
            $('#pnRegParc #btDeletar').addClass('disabled');
        } );

        tableRegParc.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnRegParc #btEditar').removeClass('disabled');
                $('#pnRegParc #btDeletar').removeClass('disabled');

                var RegParcId = tableRegParc.rows( indexes ).data().pluck( 'RegParcId' );

                var tableExecRot = $('#tbExecRot').DataTable();
                var url = "{{ route('execrot.getdata') }}"+"/?RegParcId="+RegParcId[0];
                tableExecRot.ajax.url(url).load( );

                var tablePrRotCanal = $('#tbPrRotCanal').DataTable();
                var url = "{{ route('prrotcanal.getdata') }}"+"/?RegParcId="+RegParcId[0];
                tablePrRotCanal.ajax.url(url).load( );

                $('#formExecRot #RegParcId').val(RegParcId[0]);
                $('#myModalExecRotEdita #RegParcId').val(RegParcId[0]);
                $('#pnExecRot #btInserir').removeClass('disabled');

                $('#formPrRotCanal #RegParcId').val(RegParcId[0]);
                $('#myPrRotCanal #RegParcId').val(RegParcId[0]);
                $('#pnPrRotCanal #btInserir').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnRegParc #btEditar').addClass('disabled');
                $('#pnRegParc #btDeletar').addClass('disabled');
                $('#pnExecRot #btInserir').addClass('disabled');
                $('#pnPrRotCanal #btInserir').addClass('disabled');
            } );


        $('#formRegParc').on('submit', function (e) {
            $.post( "{{ route('regparc.store') }}", $( "#formRegParc" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalRegParc').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableRegParc.ajax.reload();
                    }
                });
            return false;
        });
        $('#pnRegParc #btDeletar').click(function () {
            var linha =tableRegParc.row('.selected').data();
            var id = linha[   'RegParcId'];
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
                            'RegParcId': id,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/regparc/destroy') }}',
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

        $('#pnRegParc #btEditar').click(function () {
            var linha =tableRegParc.row('.selected').data();
            var OpRegId = linha[   'OpRegId'];
            var ParcelaQt = linha[   'ParcelaQt'];
            var FatorVr = linha[   'FatorVr'];
            var JuroDescTx = linha[   'JuroDescTx'];
            var MultaDescTx = linha[   'MultaDescTx'];
            var PrincipalDescTx = linha[   'PrincipalDescTx'];
            var EntradaMinVr = linha[   'EntradaMinVr'];
            var ParcelaMinVr = linha[   'ParcelaMinVr'];
            var RegParcId = linha['RegParcId'];
            $.ajax({
                dataType: 'json',
                type: 'GET',
                data: {
                    _token: '{!! csrf_token() !!}',
                    RegParcId:RegParcId,
                    OpRegId:OpRegId,
                    ParcelaQt:ParcelaQt,
                    FatorVr:FatorVr,
                    JuroDescTx:JuroDescTx,
                    MultaDescTx:MultaDescTx,
                    PrincipalDescTx:PrincipalDescTx,
                    EntradaMinVr:EntradaMinVr,
                    ParcelaMinVr:ParcelaMinVr,
                    _method: 'GET'
                },
                url: '{{ url('admin/regparc/1/edit/') }}',
                success: function (retorno) {
                    $('#pnRegParc #formEditar #OpRegId').val(retorno['OpRegId']);
                    $('#pnRegParc #formEditar #ParcelaQt').val(retorno['ParcelaQt']);
                    $('#pnRegParc #formEditar #FatorVr').val(retorno['FatorVr']);
                    $('#pnRegParc #formEditar #JuroDescTx').val(retorno['JuroDescTx']);
                    $('#pnRegParc #formEditar #MultaDescTx').val(retorno['MultaDescTx']);
                    $('#pnRegParc #formEditar #PrincipalDescTx').val(retorno['PrincipalDescTx']);
                    $('#pnRegParc #formEditar #EntradaMinVr').val(retorno['EntradaMinVr']);
                    $('#pnRegParc #formEditar #ParcelaMinVr').val(retorno['ParcelaMinVr']);
                    $('#pnRegParc #formEditar #RegParcId').val(RegParcId);
                },
                error: function (retorno) {
                    console.log(retorno);
                }
            });
        });

        $('#pnRegParc #formEditar').on('submit', function (e) {
            var formData = $('#pnRegParc #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/regparc/') }}'+'/' +$('#pnRegParc #formEditar #RegParcId').val(),
                success: function (data) {
                    if (data){
                        $('#myModalRegParcEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableRegParc.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalRegParcEdita').modal('toggle');
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
