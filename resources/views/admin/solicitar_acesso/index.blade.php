@extends('layouts.app')

@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css" rel="stylesheet">
@endsection
@section('content')


    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Credenciamentos</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Listagem de Credenciamentos</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Doc</th>
                                    <th>Nome</th>
                                    <th>Status</th>
                                    <th style="width: 55px">Ação</th>
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
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <script  type="text/javascript">
        $(document).ready(function() {
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    "url": "{{ route('credport.getdata2') }}"
                },
                columns: [
                    {data: 'CPF_CNPJNR', name: 'CPF_CNPJNR'},
                    {data: 'PESSOANMRS', name: 'PESSOANMRS'},
                    {
                        data: 'Ativo',
                        name: 'Ativo',
                        render: function ( data, type, row ) {
                            if(data==0){
                                return '<span class="btn btn-xs btn-dark">Aguardando</span>';
                            }
                            if(data==1){
                                return '<span class="btn btn-xs btn-success">Ativo</span>';
                            }
                            if(data==2){
                                return '<span class="btn btn-xs btn-danger">Inativo</span>';
                            }
                            return '';
                        }
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });
        });

        function deleteSolicitarAcesso(dataId) {
            swal({
                title             : "Tem certeza?",
                text              : "Este Credenciamento será deletado!",
                type              : "warning",
                showCancelButton  : true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText : "Sim",
                cancelButtonText  : "Não"
            }).then((resultado) => {
                if (resultado.value) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _method: 'DELETE',
                        _token: '{!! csrf_token() !!}',
                    },
                    url: '{{ url('admin/credport') }}' + '/' + dataId,
                    success: function( msg ) {
                        $('.datatable').DataTable().ajax.reload();
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Deletado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    error: function( data ) {
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
    };

        function ativar(id) {
            swal({
                title             : "Confirma",
                text              : "Deseja ativar?",
                type              : "warning",
                showCancelButton  : true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText : "Sim",
                cancelButtonText  : "Não"
            }).then((resultado) => {
                if (resultado.value) {
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            _token: '{!! csrf_token() !!}',
                            _method: 'PUT',
                            status:1
                        },
                        url: '{{ url('admin/credport/') }}' + '/' + id,
                        success: function (data) {
                            if (data) {
                                swal({
                                    position: 'top-end',
                                    type: 'success',
                                    title: 'Ativado com sucesso!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $('.datatable').DataTable().ajax.reload();
                            }
                        },
                        error: function (retorno) {
                            $('#myModalCredPortEdita').modal('toggle');
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
                }
            });
        }
        function inativar(id) {
            swal({
                title             : "Confirma",
                text              : "Deseja inativar?",
                type              : "warning",
                showCancelButton  : true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText : "Sim",
                cancelButtonText  : "Não"
            }).then((resultado) => {
                if (resultado.value) {
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        data: {
                            _token: '{!! csrf_token() !!}',
                            _method: 'PUT',
                            status:2
                        },
                        url: '{{ url('admin/credport/') }}' + '/' + id,
                        success: function (data) {
                            if (data) {
                                swal({
                                    position: 'top-end',
                                    type: 'success',
                                    title: 'Inativado com sucesso!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $('.datatable').DataTable().ajax.reload();
                            }
                        },
                        error: function (retorno) {
                            $('#myModalCredPortEdita').modal('toggle');
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
                }
            });
        }
    </script>

@endpush
