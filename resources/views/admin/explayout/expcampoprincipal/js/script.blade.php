<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
<script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        var table = $('#tbExpCampoPrincipal').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                "url": "{{ route('expcampoprincipal.getdata') }}",
                "data": {
                    "exp_id": '{{$ExpLayout->exp_id}}'
                }
            },
            columns: [

                {
                    data: 'epc_ord',
                    name: 'epc_ord'
                },
                {
                    data: 'epc_titulo',
                    name: 'epc_titulo'
                },
                {
                    data: 'epc_campo',
                    name: 'epc_campo'
                },


                {
                    data: 'epc_layout_id',
                    name: 'epc_layout_id',
                    "visible": false,
                    "searchable": false
                },
                {
                    data: 'epc_id',
                    name: 'epc_id',
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
            $('#pnExpCampoPrincipal #btEditar').addClass('disabled');
            $('#pnExpCampoPrincipal #btDeletar').addClass('disabled');
        } );

        table.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                $('#pnExpCampoPrincipal #btEditar').removeClass('disabled');
                $('#pnExpCampoPrincipal #btDeletar').removeClass('disabled');
            }
        } )
            .on( 'deselect', function ( e, dt, type, indexes ) {
                $('#pnExpCampoPrincipal #btEditar').addClass('disabled');
                $('#pnExpCampoPrincipal #btDeletar').addClass('disabled');
            } );


        $('#formExpCampoPrincipal').on('submit', function (e) {
            $.post( "{{ route('expcampoprincipal.store') }}", $( "#formExpCampoPrincipal" ).serialize() )
                .done(function( data ){
                    if (data){
                        $('#myModalExpCampoPrincipal').modal('toggle');
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Salvo com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload();
                        $("#formExpCampoPrincipal").trigger('reset');
                    }
                });
            return false;
        });
        $('#pnExpCampoPrincipal #btDeletar').click(function () {
            var linha =table.row('.selected').data();
            var id = linha[   'epc_id'];
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
                            'epc_id': id,
                            _method: 'DELETE'
                        },
                        url: '{{ url('admin/expcampoprincipal/destroy') }}',
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

        $('#pnExpCampoPrincipal #btEditar').click(function () {
            var linha =table.row('.selected').data();

            var exp_tabela = '{{$ExpLayout->exp_tabela}}';
            var epc_ord = linha[   'epc_ord'];
            var epc_campo = linha[   'epc_campo'];
            var epc_titulo = linha[   'epc_titulo'];

            var epc_id = linha['epc_id'];
            $('#pnExpCampoPrincipal #formEditar #epc_id').val(epc_id);
            $('#pnExpCampoPrincipal #formEditar #epc_ord').val(epc_ord);
            $('#pnExpCampoPrincipal #formEditar #epc_campo').val(epc_campo);
            $('#pnExpCampoPrincipal #formEditar #epc_titulo').val(epc_titulo);
            reloadCampo('#myModalExpCampoPrincipalEdita #epc_campo',exp_tabela,epc_campo);

        });

        $('#pnExpCampoPrincipal #formEditar').on('submit', function (e) {
            var formData = $('#pnExpCampoPrincipal #formEditar').serialize();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                data:formData,
                url: '{{ url('admin/expcampoprincipal/') }}'+'/' +$('#pnExpCampoPrincipal #formEditar #epc_id').val(),
                success: function (data) {
                    if (data){
                        $('#myModalExpCampoPrincipalEdita').modal('toggle');
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
                    $('#myModalExpCampoPrincipalEdita').modal('toggle');
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