<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#tbTratRet').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('tratret.getdata') }}",
                "data": {
                    "CANALID": '{{$canal->CANALID}}'
                }
            },
            columns: [

                {
                    data: 'RetornoCd',
                    name: 'RetornoCd'
                },

                {
                    data: 'EventoSg',
                    name: 'EventoSg'
                },
                {
                    data: 'RetornoCdNr',
                    name: 'RetornoCdNr'
                },
                {
                    data: 'EventoId',
                    name: 'EventoId',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'TratRetId',
                    name: 'TratRetId',
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
            $('#pnTratRet #btEditar').addClass('disabled');
            $('#pnTratRet #btDeletar').addClass('disabled');
        } );

        table.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnTratRet #btEditar').removeClass('disabled');
                $('#pnTratRet #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnTratRet #btEditar').addClass('disabled');
                $('#pnTratRet #btDeletar').addClass('disabled');
            } );


        $('#formTratRet').on('submit', function (e) {
            $.post( "{{ route('tratret.store') }}", $( "#formTratRet" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalTratRet').modal('toggle');
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
        $('#pnTratRet #btDeletar').click(function () {
            var linha =table.row('.selected').data();
            var TratRetId = linha[   'TratRetId'];
            var EventoId = linha[   'EventoId'];
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
                            'CanalId': '{{$canal->CANALID}}',
                            'TratRetId': TratRetId,
                            'EventoId': EventoId,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/tratret/destroy') }}',
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

        $('#pnTratRet #btEditar').click(function () {
            var linha =table.row('.selected').data();
            var TratRetId = linha[   'TratRetId'];
            $.ajax({
                dataType: 'json',
                type: 'GET',
                data: {
                    _token: '{!! csrf_token() !!}',
                    id:TratRetId
                },
                url: '{{ url('admin/tratret/1/edit') }}',
                success: function (retorno) {
                    $('#myModalTratRetEdita #RetornoCd').val(retorno['RetornoCd']);
                    $('#myModalTratRetEdita #RetornoCdNr').val(retorno['RetornoCdNr']);
                    $('#myModalTratRetEdita #EventoId').val(retorno['EventoId']);
                    $('#myModalTratRetEdita #TratRetId').val(TratRetId);
                },
                error: function (retorno) {
                    console.log(retorno);
                }
            });
        });

        $('#pnTratRet #formEditar').on('submit', function (e) {
            var linha =table.row('.selected').data();
            var TratRetId = linha[   'TratRetId'];
            $.post( '{{ url('admin/tratret') }}' + '/' + TratRetId, $( "#pnTratRet #formEditar" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalTratRetEdita').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Editado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload();
                    }
                })
                .error(function (retorno){
                    $('#myModalTratRetEdita').modal('toggle');
                    console.log(retorno.responseJSON.message);
                    swal({
                        position: 'top-end',
                        type: 'error',
                        title: 'Erro!',
                        text: retorno.responseJSON.message,
                        showConfirmButton: false,
                        timer: 7500
                    });
                })
            ;
            return false;
        });


    });
</script>