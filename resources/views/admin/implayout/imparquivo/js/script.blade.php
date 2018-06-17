<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var tableImpArquivo = $('#tbImpArquivo').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('imparquivo.getdata') }}",
                "data": {
                    "LayoutId": '{{$ImpLayout->LayoutId}}'
                }
            },
            columns: [
                {
                    data: 'ArquivoOrd',
                    name: 'ArquivoOrd'
                },
                {
                    data: 'ArquivoDs',
                    name: 'ArquivoDs'
                },
                {
                    data: 'REGTABNM',
                    name: 'REGTABNM'
                },
                {
                    data: 'TpArqId',
                    name: 'TpArqId',
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
                    data: 'ArquivoId',
                    name: 'ArquivoId',
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

        tableImpArquivo.on( 'draw', function () {
            $('#pnImpArquivo #btEditar').addClass('disabled');
            $('#pnImpArquivo #btDeletar').addClass('disabled');
        } );

        tableImpArquivo.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnImpArquivo #btEditar').removeClass('disabled');
                $('#pnImpArquivo #btDeletar').removeClass('disabled');

                var TabelaBD = tableImpArquivo.rows( indexes ).data().pluck( 'TabelaBD' );
                var ArquivoId = tableImpArquivo.rows( indexes ).data().pluck( 'ArquivoId' );

                reloadCampo('#formImpCampo #CampoDB',TabelaBD[0]);
                reloadCampo('#myModalImpCampoEdita #CampoDB',TabelaBD[0]);

                $('#formImpCampo #ArquivoId').val(ArquivoId[0]);
                $('#myModalImpCampoEdita #ArquivoId').val(ArquivoId[0]);

                var tableImpCampo = $('#tbImpCampo').DataTable();
                var url = "{{ route('impcampo.getdata') }}"+"/?ArquivoId="+ArquivoId[0];
                tableImpCampo.ajax.url(url).load( );
                $('#pnImpCampo #btInserir').removeClass('disabled');

            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnImpArquivo #btEditar').addClass('disabled');
                $('#pnImpArquivo #btDeletar').addClass('disabled');

                $('#pnImpCampo #btInserir').addClass('disabled');
            } );


        $('#formImpArquivo').on('submit', function (e) {
            $.post( "{{ route('imparquivo.store') }}", $( "#formImpArquivo" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalImpArquivo').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableImpArquivo.ajax.reload();
                        $("#formImpArquivo").trigger('reset');
                    }
                });
            return false;
        });
        $('#pnImpArquivo #btDeletar').click(function () {
            var linha =tableImpArquivo.row('.selected').data();
            var id = linha[   'ArquivoId'];
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
                            'ArquivoId': id,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/imparquivo/destroy') }}',
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

        $('#pnImpArquivo #btEditar').click(function () {
            var linha =tableImpArquivo.row('.selected').data();
            var LayoutId = '{{$ImpLayout->LayoutId}}';
            var ArquivoDs = linha[   'ArquivoDs'];
            var TabelaBD = linha[   'TabelaBD'];
            var ArquivoOrd = linha[   'ArquivoOrd'];
            var TpArqId = linha[   'TpArqId'];
            var ArquivoId = linha['ArquivoId'];
            $('#pnImpArquivo #formEditar #LayoutId').val(LayoutId);
            $('#pnImpArquivo #formEditar #ArquivoDs').val(ArquivoDs);
            $('#pnImpArquivo #formEditar #TabelaBD').val(TabelaBD);
            $('#pnImpArquivo #formEditar #ArquivoOrd').val(ArquivoOrd);
            $('#pnImpArquivo #formEditar #TpArqId').val(TpArqId);
            $('#pnImpArquivo #formEditar #ArquivoId').val(ArquivoId);
        });

        $('#pnImpArquivo #formEditar').on('submit', function (e) {
            var formData = $('#pnImpArquivo #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/imparquivo/') }}'+'/' +$('#pnImpArquivo #formEditar #ArquivoId').val(),
                success: function (data) {
                    if (data){
                        $('#myModalImpArquivoEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        tableImpArquivo.ajax.reload();
                    }
            },
                error: function (retorno) {
                    $('#myModalImpArquivoEdita').modal('toggle');
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