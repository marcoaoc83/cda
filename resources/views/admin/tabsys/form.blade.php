@extends('layouts.app')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.1.2/css/select.dataTables.min.css" rel="stylesheet">
@endsection
@section('content')
    <!-- page content -->
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Tabela do Sistema</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <a class="btn btn-app" onclick="$('#send').trigger('click')">
                                <i class="fa fa-save"></i> Salvar
                            </a>
                            <a class="btn btn-app" href="{{Request::url()}}">
                                <i class="fa fa-repeat"></i> Atualizar
                            </a>
                            <a class="btn btn-app" href="{{ route('admin.tabsys') }}">
                                <i class="fa fa-arrow-circle-left"></i> Voltar
                            </a>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Dados da Tabela <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left"    method="post" action="{{ route('tabsys.editarPost',$tabsys->TABSYSID) }}">
                                {{ csrf_field() }}
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Sigla <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{$tabsys->TABSYSSG}}" id="TABSYSSG" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="TABSYSSG"  required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TABSYSNM">Nome <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{$tabsys->TABSYSNM}}"  type="text" id="TABSYSNM" name="TABSYSNM" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">SQL
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="TABSYSSQL" name="TABSYSSQL" value="1" class="js-switch" @if($tabsys->TABSYSSQL==1) checked @endif >
                                        </label>
                                    </div>
                                </div>

                                <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>
                            </form>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_content x_title profile_title">
                            <a class="btn btn-default btn-xs" id="btInserir"  data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus-square"> Inserir</i>
                            </a>
                            <!-- Modal -->
                            <div id="myModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Inserir</h4>
                                        </div>
                                        <div class="modal-body">
                                                <form id="formModal"  class="form-horizontal form-label-left" >
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="TABSYSID" value="{{$tabsys->TABSYSID}}">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sigla<span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" id="REGTABSG" name="REGTABSG" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nome<span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <input type="text" id="REGTABNM" name="REGTABNM" required="required" class="form-control col-md-7 col-xs-12">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">SQL</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea class="form-control" rows="3" id="REGTABSQL" name="REGTABSQL"></textarea>

                                                        </div>
                                                    </div>
                                                    <div class="ln_solid"></div>
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                            <button type="submit" class="btn btn-success" id="btnSalvar">Salvar</button>
                                                        </div>
                                                    </div>

                                                </form>


                                        </div>
                                    </div>

                                </div>
                            </div>
                            <a class="btn btn-default btn-xs disabled" id="btEditar">
                                <i class="fa fa-pencil-square-o"> Editar</i>
                            </a>
                            <a class="btn btn-default btn-xs disabled" id="btDeletar">
                                <i class="fa fa-trash"> Deletar</i>
                            </a>
                        </div>
                        <div class="x_content">

                            <table class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Sigla</th>
                                    <th>Nome</th>
                                    <th>SQL</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js">
    </script>

    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
    <script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var disp=false;
            if($("#TABSYSSQL").is(':checked')){
                disp=true;
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
                    if (resultado.value)
                    {
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


        });


    </script>
@endpush