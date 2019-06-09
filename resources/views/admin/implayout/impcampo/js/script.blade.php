<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#tbImpCampo').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('impcampo.getdata') }}",
                "data": {
                    "LayoutId": '{{$ImpLayout->LayoutId}}'
                }
            },
            columns: [

                {
                    data: 'OrdTable',
                    name: 'OrdTable'
                },

                {
                    data: 'CampoNm',
                    name: 'CampoNm'
                },
                {
                    data: 'TabelaDB',
                    name: 'TabelaDB'
                },
                {
                    data: 'CampoDB',
                    name: 'CampoDB'
                },
                {
                    data: 'CampoValorFixo',
                    name: 'CampoValorFixo'
                },
                {
                    data: 'FKTabela',
                    name: 'FKTabela',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'FKCampo',
                    name: 'FKCampo',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'CampoTipo',
                    name: 'CampoTipo',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'LayoutId',
                    name: 'LayoutId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'CampoID',
                    name: 'CampoID',
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
            $('#pnImpCampo #btEditar').addClass('disabled');
            $('#pnImpCampo #btDeletar').addClass('disabled');
        } );

        table.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnImpCampo #btEditar').removeClass('disabled');
                $('#pnImpCampo #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnImpCampo #btEditar').addClass('disabled');
                $('#pnImpCampo #btDeletar').addClass('disabled');
            } );


        $('#formImpCampo').on('submit', function (e) {
            $.post( "{{ route('impcampo.store') }}", $( "#formImpCampo" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalImpCampo').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload();
                        $("#formImpCampo").trigger('reset');
                    }
                });
            return false;
        });
        $('#pnImpCampo #btDeletar').click(function () {
            var linha =table.row('.selected').data();
            var id = linha[   'CampoID'];
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
                            'CampoID': id,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/impcampo/destroy') }}',
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

        $('#pnImpCampo #btEditar').click(function () {
            var linha =table.row('.selected').data();
            var LayoutId = '{{$ImpLayout->LayoutId}}';
            var CampoNm = linha[   'CampoNm'];
            var TabelaDB = linha[   'TabelaDB'];
            var CampoDB = linha[   'CampoDB'];
            var CampoPK = linha[   'CampoPK'];
            var CampoValorFixo = linha['CampoValorFixo'];
            var CampoTipo = linha['CampoTipo'];
            var CampoID = linha['CampoID'];
            $('#pnImpCampo #formEditar #LayoutId').val(LayoutId);
            $('#pnImpCampo #formEditar #CampoNm').val(CampoNm);
            $('#pnImpCampo #formEditar #TabelaDB').val(TabelaDB);
            reloadCampo('#formEditar #CampoDB',TabelaDB,CampoDB);
            reloadCampo('#formEditar #FKCampo',linha['FKTabela'],linha['FKCampo']);
            $('#pnImpCampo #formEditar #CampoPK').val(CampoPK);
            $('#pnImpCampo #formEditar #FKTabela').val( linha['FKTabela']);
            $('#pnImpCampo #formEditar #FKCampo').val( linha['FKCampo']);
            $('#pnImpCampo #formEditar #CampoValorFixo').val(CampoValorFixo);
            $('#pnImpCampo #formEditar [name=\'CampoTipo\']').trigger('click');
            $('#pnImpCampo #formEditar [name="CampoTipo"][value='+CampoTipo+']').trigger('click');
            $('#pnImpCampo #formEditar #CampoID').val(CampoID);
            $('#pnImpCampo #formEditar #CampoDB').val(CampoDB);
            $('#pnImpCampo #formEditar #OrdTable').val( linha['OrdTable']);
            $('#pnImpCampo #formEditar #TipoDados').val( linha['TipoDados']);
        });

        $('#pnImpCampo #formEditar').on('submit', function (e) {
            var formData = $('#pnImpCampo #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/impcampo/') }}'+'/' +$('#pnImpCampo #formEditar #CampoID').val(),
                success: function (data) {
                    if (data){
                        $('#myModalImpCampoEdita').modal('toggle');
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
                    $('#myModalImpCampoEdita').modal('toggle');
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