<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var disp=false;
        $('.sql').addClass('hidden');
        if($("#TABSYSSQL").is(':checked')){
            disp=true;
            $('.sql').addClass('hidden');
        }
        var table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('regtab.getdata') }}",
                "data": {
                    "TABSYSID": '{{$tabsys->TABSYSID}}'
                }
            },
            columns: [
                {
                    data: 'REGTABID',
                    name: 'REGTABID',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'REGTABSG',
                    name: 'REGTABSG'
                },
                {
                    data: 'REGTABNM',
                    name: 'REGTABNM'
                },
                {
                    data: 'REGTABSQL',
                    name: 'REGTABSQL',
                    "visible": disp,
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
            $('#btEditar').addClass('disabled');
            $('#btDeletar').addClass('disabled');
        } );

        $("#TABSYSSQL").click(function(){
            // Get the column API object
            var column = table.column('3');

            // Toggle the visibility
            column.visible(!column.visible());
            if($("#TABSYSSQL").is(':checked')) {
                $('.sql').removeClass('hidden');
            }else{
                $('.sql').addClass('hidden');
            }
        });

        table.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#btEditar').removeClass('disabled');
                $('#btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#btEditar').addClass('disabled');
                $('#btDeletar').addClass('disabled');
            } );


        $('#formModal').on('submit', function (e) {
            $.post( "{{ route('regtab.inserirPost') }}", $( "#formModal" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModal').modal('toggle');
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
        $('#btDeletar').click(function () {
            var linha =table.row('.selected').data();
            var REGTABID = linha[   'REGTABID'];
            swal({
                title             : "Tem certeza?",
                text              : "Esta Registro será deletada!",
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
                        },
                        url: '{{ url('admin/regtab/deletar') }}' + '/' + REGTABID,
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

        $('#btEditar').click(function () {
            var linha =table.row('.selected').data();
            var REGTABID = linha[   'REGTABID'];
            $.ajax({
                dataType: 'json',
                type: 'GET',
                data: {
                    _token: '{!! csrf_token() !!}',
                    id:REGTABID
                },
                url: '{{ url('admin/regtab/editar') }}',
                success: function (retorno) {
                    $('#REGTABSG_edt').val(retorno['REGTABSG']);
                    $('#REGTABNM_edt').val(retorno['REGTABNM']);
                    $('#REGTABSQL_edt').val(retorno['REGTABSQL']);
                },
                error: function (retorno) {
                    console.log(retorno);
                }
            });
        });

        $('#formEditar').on('submit', function (e) {
            var linha =table.row('.selected').data();
            var REGTABID = linha[   'REGTABID'];
            $.post( '{{ url('admin/regtab/editar') }}' + '/' + REGTABID, $( "#formEditar" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#modalEdita').modal('toggle');
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
                    $('#modalEdita').modal('toggle');
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