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
                    <h3>Pessoas</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Listagem de Pessoas</h2>
                            <a href="{{route('pessoa.create')}}" style="margin-left: 15px" type="button" class="btn btn-success btn-sm ">
                                <span class="glyphicon glyphicon-plus-sign "  style="color:white" aria-hidden="true"></span>
                                Adicionar
                            </a>
                            @if(auth()->user()->funcao==1)
                            <a href="javascript:;" onclick="deletePessoaAll()" style="margin-left: 15px" type="button" class="btn btn-danger btn-sm ">
                                <span class="glyphicon glyphicon-minus-sign "  style="color:white" aria-hidden="true"></span>
                                Deletar Dados
                            </a>
                            @endif
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i class="fa fa-download"></i></a>
                                    <ul class="dropdown-menu" role="menu" style="background-color: #f0f0f0">
                                        <li><a href="{{route("pessoa.export",["tipo"=>'pdf'])}}" target="_blank"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
                                        <li><a href="{{route("pessoa.export",["tipo"=>'csv'])}}" target="_blank"><i class="fa fa-file-excel-o"></i> CSV</a></li>
                                        <li><a href="{{route("pessoa.export",["tipo"=>'txt'])}}" target="_blank"><i class="fa fa-file-text-o"></i> TXT</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nome</th>
                                    <th>CPF / CNPJ</th>
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
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('pessoa.getdata') }}',
                columns: [
                    {data: 'PESSOAID', name: 'PESSOAID'},
                    {data: 'PESSOANMRS', name: 'PESSOANMRS'},
                    {data: 'CPF_CNPJNR', name: 'CPF_CNPJNR'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });
        });

        function deletePessoa(dataId) {
            swal({
                title             : "Tem certeza?",
                text              : "Esta Pessoa será deletada!",
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
                    url: '{{ url('admin/pessoa') }}' + '/' + dataId,
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
        function deletePessoaAll() {
            swal({
                title             : "Tem certeza?",
                text              : "Todos os dados serão deletados!",
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
                            all:true,
                            _token: '{!! csrf_token() !!}',
                        },
                        url: '{{ url('admin/pessoa') }}' + '/' + 1,
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