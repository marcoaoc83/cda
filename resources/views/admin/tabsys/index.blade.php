@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Tabelas do Sistema</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Listagem de Tabelas do Sistema</h2>
                            <a href="{{route('tabsys.inserirGet')}}" style="margin-left: 15px" type="button" class="btn btn-success btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign "  style="color:white" aria-hidden="true"></span>
                                Adicionar
                            </a>

                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            {{--class="table table-bordered table-striped"--}}
                            <table class="table table-bordered table-striped datatable display responsive nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Sigla</th>
                                    <th>Nome</th>
                                    <th>SQL</th>
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
    <script src={{ asset('bower_components/datatables.net/js/jquery.dataTables.js') }}></script>
    <script src={{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}></script>
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('tabsys.getdata') }}',
                columns: [
                    {data: 'TABSYSID', name: 'TABSYSID'},
                    {data: 'TABSYSSG', name: 'TABSYSSG'},
                    {data: 'TABSYSNM', name: 'TABSYSNM'},
                    {data: 'TABSYSSQL', name: 'TABSYSSQL'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });
        });

        function deleteTabelasSistema(dataId) {
            swal({
                title             : "Tem certeza?",
                text              : "Esta Tabela será deletada!",
                type              : "warning",
                showCancelButton  : true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText : "Sim",
                cancelButtonText  : "Não"
            }).then((resultado) => {
                if (resultado.value) {
                $.ajax({
                    dataType : 'json',
                    type: 'POST',
                    data: {
                        _token: '{!! csrf_token() !!}',
                    },
                    url: '{{ url('admin/tabsys/deletar') }}' + '/' + dataId,
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
    </script>
@endpush